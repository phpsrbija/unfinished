
<?php

return [
    "paths"        => [
        "migrations" => "migrations/"
    ],
    "environments" => [
        "default_migration_table" => "migrations_log",
        "default_database"        => "default",

        // all DB connections
        "default"                 => [
            "adapter" => 'mysql',
            "host"    => 'localhost',
            "name"    => 'unfinished',
            "user"    => 'root',  // set username
            "pass"    => '12345', // and pass
            "port"    => '5432'
        ]
    ]
];
