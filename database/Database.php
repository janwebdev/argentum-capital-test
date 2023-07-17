<?php

namespace database;

class Database
{
    private string $db_host;
    private string $db_user;
    private string $db_pass;
    private string $db_name;
    private \mysqli|false|null $connection = null;

    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }
    public function connect(): bool
    {
        if (!$this->connection) {
            $this->connection = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
            if($this->connection) {
                $seldb = mysqli_select_db($this->connection, $this->db_name);
                if($seldb) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    public function disconnect(): void
    {
        mysqli_close($this->connection);
    }

    public function getRightsByGroup(string $sourceName, int $groupId): bool|array
    {
        $sourceParts = explode('::', $sourceName);
        $module = $sourceParts[0];


        $query = "SELECT g.id, p.id as pid, p.source FROM groups g 
            LEFT JOIN group_permission gp ON g.id = gp.group_id 
            LEFT JOIN permissions p ON gp.permission_id = p.id  
            WHERE g.id = '".$groupId."' AND (p.source = '".$module."' OR p.source = '".$sourceName."');";
        $result = $this->connection->query($query);
        if($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function getRightsByUser(string $sourceName, string $username): bool|array
    {
        $sourceParts = explode('::', $sourceName);
        $module = $sourceParts[0];

        $query = "SELECT u.id, p.id as pid, p.source FROM users u 
            LEFT JOIN user_permission up ON u.id = up.user_id 
            LEFT JOIN permissions p ON up.permission_id = p.id  
            WHERE u.username = '".$username."' AND (p.source = '".$module."' OR p.source = '".$sourceName."');";
        $result = $this->connection->query($query);
        if($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function getUserGroups(string $username): bool|array
    {
        $query = "SELECT u.id, u.username, g.id as gid, g.name FROM users u 
                  LEFT JOIN users_in_groups uig on u.id = uig.user_id 
                  LEFT JOIN `groups` g on g.id = uig.group_id
                  WHERE u.username = '".$username."';";
        $result = $this->connection->query($query);
        if($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
    }

    public function select(string $table, string $rows = '*', ?string $where = null, ?string $order = null): bool|array
    {
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
        if($this->tableExists($table)) {
            $result = $this->connection->query($q);
            if($result) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function tableExists($table): bool
    {
        $tablesInDb = mysqli_query($this->connection, 'SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"');
        if($tablesInDb) {
            if(mysqli_num_rows($tablesInDb) == 1) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function getConnection()
    {
        return $this->connection;
    }

}