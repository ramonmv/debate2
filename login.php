<?php

// phpinfo();

// MYSQL_VERSION=latest
// MYSQL_DATABASE=default
// MYSQL_USER=ramon
// MYSQL_PASSWORD=password
// MYSQL_PORT=3306
// MYSQL_ROOT_PASSWORD=amadis
// MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d


$link = mysqli_connect("mysql", "ramon", "password", "debate");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    // exit;
}
else{

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

}

mysqli_close($link);






echo "<br>";
echo "<br>";
echo "<br>";

$link = mysqli_connect("mysql", "ramon", "amadis", "debate");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    // exit;
}

else{

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
    
}

mysqli_close($link);








echo "<br>";
echo "<br>";
echo "<br>";

$link = mysqli_connect("mysql", "root", "password", "debate");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    // exit;
}

else{

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
    
}

mysqli_close($link);






echo "<br>";
echo "<br>";
echo "<br>";

$link = mysqli_connect("mysql", "root", "amadis", "debate");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    // exit;
}

else{

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;
    
}

mysqli_close($link);







?>