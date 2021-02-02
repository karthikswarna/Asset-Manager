<?php

    DEFINE('DB_USER', 'root');
    DEFINE('DB_PASSWORD', '1017f001');
    DEFINE('DB_NAME', 'assets_db');
    DEFINE('DB_HOST', 'localhost');

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    try
    {
        $db_conn = new PDO($dsn, DB_USER, DB_PASSWORD);
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        // $err_msg = $e->getMessage();
        // echo $err_msg;
        // exit();
        die("ERROR: Could not connect. " . $e->getMessage());
    }

?>