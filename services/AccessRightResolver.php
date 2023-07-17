<?php

namespace services;

use contracts\ResolverInterface;
use database\Database;

class AccessRightResolver implements ResolverInterface
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function resolveAccess(string $username, string $moduleName, string $functionName): bool
    {

        $groups = $this->database->getUserGroups($username);

        $hasGroupAccess = false;

        foreach($groups as $group) {

            $groupAccess = $this->getDatabase()->getRightsByGroup($moduleName.'::'.$functionName, $group['gid']);

            $hasGroupAccess = !empty($groupAccess);

        }

        if (!$hasGroupAccess) {
            $userAccess = $this->getDatabase()->getRightsByUser($moduleName.'::'.$functionName, $username);

            return !empty($userAccess);
        }

        return $hasGroupAccess;

    }

    public function isUserExists(string $username): bool
    {
        return !empty($this->getDatabase()->select('users', '*', 'username="'.$username.'"'));
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }


}