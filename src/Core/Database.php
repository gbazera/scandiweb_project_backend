<?php

namespace App\Core;

use mysqli;

class Database{

    public static function connect(): mysqli{

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'scandiweb_project';

        return new mysqli($host, $username, $password, $database);
    }
}