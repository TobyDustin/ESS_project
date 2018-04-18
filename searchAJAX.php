<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 17/03/2018
 * Time: 14:51
 */
require 'connection.php';
$block="<table>";
if (isset($_GET['delServ'])){
    $service = $_GET['term'];
    $sql= "SELECT serv_id, service_name FROM tbl_services WHERE service_name LIKE '%$service%'";
    foreach ($conn->query($sql) as $row) {
        $serv_name = $row[service_name];
        $serv_id = $row[serv_id];
        $block .="<tr><td style='padding-left: 5px; border: solid 1px black'><a href='adminDashboard.php?id=$serv_id&delService=Submit'>$serv_name</a></td></tr>";
    }

    $block.="</table>";
    echo $block;

}elseif (isset($_GET['delStaff'])){
    $staff = $_GET['term'];
    $sql= "SELECT staff_id,first_name, last_name FROM tbl_staff WHERE first_name LIKE '%$staff%' OR last_name LIKE  '%$staff%' OR email LIKE '%$staff%' ";
    foreach ($conn->query($sql) as $row) {
        $staff_id = $row[staff_id];
        $first = ucfirst($row[first_name]);
        $last =  ucfirst($row[last_name]);
        $block .="<tr><td style='padding-left: 5px; border: solid 1px black'><a href='adminDashboard.php?id=$staff_id&delStaff'>$first $last</a></td></tr>";
    }

    $block.="</table>";
    echo $block;

}elseif (isset($_GET['addStaff'])){
$service = $_GET['term'];
$sql = "SELECT serv_id, service_name FROM tbl_services WHERE service_name LIKE '%$service%' ";
foreach ($conn->query($sql) as $row) {
    $serv_name = $row[service_name];
    $serv_id = $row[serv_id];
    $block .= "<tr><td style='padding-left: 5px; border: solid 1px black'><a onclick='addService($serv_id)'>$serv_name</a></td></tr>";
}

$block.="</table>";
echo $block;

}

else{
    echo 'hello';
}
