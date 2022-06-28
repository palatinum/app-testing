<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager;

final class Connection {
    public static function init () {
        $capsule = new Manager;
        $capsule->addConnection([
            "driver" => $_ENV['CONNECTION_DRIVER'],
            "host" => $_ENV['CONNECTION_HOST'],
            "database" => $_ENV['CONNECTION_NAME'],
            "username" => $_ENV['CONNECTION_USER'],
            "password" => $_ENV['CONNECTION_PASSWORD']
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
