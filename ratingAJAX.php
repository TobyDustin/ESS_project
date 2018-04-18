<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 16/03/2018
 * Time: 22:01
 */
require 'connection.php';
$c = $_GET['c'];
$s = $_GET['s'];
$r = $_GET['r'];
try {
    $sql = "INSERT INTO tbl_ratings(client_id, staff_id, rating) VALUES ('$c','$s','$r')";
    // use exec() because no results are returned
    $conn->exec($sql);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
echo "<script>console.log('hello');</script>";



