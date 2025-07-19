<?php

namespace App\Core;

use mysqli;

class Database{

    public static function connect(): mysqli{

        $host = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        $database = $_ENV['DB_NAME'];

        return new mysqli($host, $username, $password, $database);
    }
}