<?php

require 'vendor/autoload.php';

use models\User;
use database\Database;
use services\AccessRightResolver;

final class DataBaseConfig
{
    public const DB_HOST = 'mysql';
    public const DB_USER = 'admin';
    public const DB_PASSWORD = 'password';
    public const DB_NAME = 'argentum_database';
}


runApp();

function runApp(): void
{
    $database = new Database(DataBaseConfig::DB_HOST, DataBaseConfig::DB_USER, DataBaseConfig::DB_PASSWORD, DataBaseConfig::DB_NAME);

    $database->connect();

    $resolver = new AccessRightResolver($database);

    $username = trim($_SERVER['argv'][1]);

    $isUserExists = $resolver->isUserExists($username);

    if (false === $isUserExists) {
        throw new \RuntimeException(sprintf("User '%s' does not exist", $username));
    }

    foreach (scandir(__DIR__ . '/modules') as $file) {
        if ($file !== '.' && $file !== '..') {
            $files[] = $file;
        }
    }

    foreach ($files as $file) {
        $parts = explode(".", $file);
        $className = $parts[0];
        print "---> Checking module: " . $className . "\n";
        $classFQCN = '\modules\\' . $parts[0];

        $reflectionClass = new \ReflectionClass($classFQCN);
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method) {
            $isAccessGrantedToFunction = $resolver->resolveAccess($username, $className, $method->name);
            if ($isAccessGrantedToFunction) {

                printf("Access is granted for function '%s' in module '%s'\n", $method->name, $className);

            } else {

                printf("Access is not granted for function '%s' in module '%s'\n", $method->name, $className);

            }
        }

    }

    $database->disconnect();

}