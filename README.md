## Argentum Capital Test Project

### Agenda

The application should implement simple permissions system, that work for users, which can be structured in groups.

Permissions should store access rights to module/module+function, based on user group or user itself.

```php
FYI: Logical modules and their's functions are located in ./modules dir at the code level
```

The application should have an ability to store unlimited users, groups and permissions.

`Group` can have many permissions as well as several groups can have the same permission.

Also, `User` can have many permissions as well as several users can have the same permission.

For simplicity, the application is build in plain PHP code, without using frameworks and/or libraries, using simple `mysqli` functions (not PDO) for communicationg with database.

### Prerequisites

To run this project you need `docker`, `docker compose` and `make` utility to be installed, or, at least, to have running PHP 8+ and MySQL 5.7+ instances running on your local system.

To launch the project run the following commands:

1. `docker compose build`
2. `make up`

Prepare database for project to run.
Execute the dump file, located in `./sql/dump.sql`, using your RDBMS on `localhost:5299`

The uppermentioned dump-file contains database structure, as well as demo data in format of sql commands.

```php
Please note, that all the necessary hosts and ports, needed to run project in docker, are hardcoded.
If you need to setup database connection, please edit <DataBaseConfig> class in ./index.php file
```

To access built and started containers, run:
3. `make ssh`

To run the code itself, inside the container, run:
4. `php index.php ${username}`

where `${username}` is `admin`, `programmer` or `manager`

```php
The result of script will show in terminal the access right for each function of each module, that are localted in ./modules dir, based on the "demo data".
```

### How Tos

#### How to add a permission

The permission identifier is stored in `permissions` db table in `source` column in format of `${moduleName}::${functionName}`.

If you want to add permission to whole module - insert just `${moduleName}`; if function - `${moduleName}::${functionName}`.

You also need to add relation of permission to `Group` or `User`;

For doing that, please make the necessary inserts in `groups_permissions` or `users_permissions` tables respectively.