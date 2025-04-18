<?
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "businessdb";
    $conn    = "";

    try {
        $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    } catch(mysqli_sql_exception) {
        exit "Could not connect!";
    }
