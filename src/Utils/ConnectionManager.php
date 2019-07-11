<?php


namespace Auth\Utils;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\PDOMySql\Driver as MySqlDriver;
use Doctrine\DBAL\Driver\PDOSqlite\Driver as SqliteDriver;
use Exception;

class ConnectionManager
{
    /**
     * @var Connection
     */
    private static $connectionFroCreatingDatabases;

    public static function dropAndCreateDatabase(): void
    {
        if (empty(self::$connectionFroCreatingDatabases)) {
            self::$connectionFroCreatingDatabases = new Connection([
                'user' => self::getUser(),
                'password' => self::getPassword(),
                'host' => self::getHost(),
            ], self::getDriver());
        }

        self::$connectionFroCreatingDatabases->exec(sprintf('DROP DATABASE IF EXISTS %s', self::getDbName()));
        self::$connectionFroCreatingDatabases->exec(sprintf('CREATE DATABASE %s', self::getDbName()));
    }

    private static function getUser(): ?string
    {
        return $GLOBALS['DB_USER'] ?? null;
    }

    private static function getPassword(): ?string
    {
        return $GLOBALS['DB_PASSWORD'] ?? null;
    }

    private static function getHost(): ?string
    {
        return $GLOBALS['DB_HOST'] ?? null;
    }

    private static function getDriver(): Driver
    {
        if (!isset($GLOBALS['DB_DRIVER'])) {
            throw new Exception('Please set DB_DRIVER in global config');
        }

        if ($GLOBALS['DB_DRIVER'] === 'pdo_mysql') {
            return new MySqlDriver();
        }

        throw new Exception(sprintf('DB_DRIVER "%s" not supported', $GLOBALS['DB_DRIVER']));
    }

    public static function createConnection(): Connection
    {
        return new Connection([
            'user' => self::getUser(),
            'password' => self::getPassword(),
            'host' => self::getHost(),
        ], self::getDriver());
    }

    public static function createSqliteMemoryConnection()
    {
        return new Connection([ 'memory' => true ], new SqliteDriver());
    }
}