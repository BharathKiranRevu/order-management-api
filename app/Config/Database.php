<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    public array $default = [
        'hostname'   => '127.0.0.1',    // ← use 127.0.0.1 instead of localhost (fixes MySQLi bugs on Windows)
        'username'   => 'root',
        'password'   => '',
        'database'   => 'tasknew',
        'DBDriver'   => 'MySQLi',
        'port'       => 3306,
        'DBDebug'    => true,
        'charset'    => 'utf8mb4',
        'DBCollat'   => 'utf8mb4_general_ci',
        'pConnect'   => false,
        'strictOn'   => false,
    ];

    public array $tests = [
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
    ];

    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}