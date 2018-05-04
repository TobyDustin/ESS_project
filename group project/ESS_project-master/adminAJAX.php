<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 15/03/2018
 * Time: 16:34
 */
require 'connection.php';
$service = "SELECT f.first_name,f.last_name,s.service_name,c.first_name AS cfirst, c.last_name AS clast, t.timestamp FROM tbl_ticket t JOIN tbl_staff f ON (t.staff_id=f.staff_id) JOIN tbl_clients c ON (t.client_id=c.client_id) JOIN tbl_services s ON (t.service_id=s.serv_id) ORDER BY t.timestamp DESC";
$blocks="<table class='tableLive'><tr><th>STAFF</th><th>SERVICE</th><th>CUSTOMER</th><th>TIME</th></tr>";
foreach ($conn->query($service) as $row) {
    $row[first_name] = ucfirst($row[first_name]);
    $row[last_name] = ucfirst($row[last_name]);
    $row[cfirst] = ucfirst($row[cfirst]);
    $row[clast] = ucfirst($row[clast]);
   $blocks .= "<tr><td>$row[first_name] $row[last_name]</td><td>$row[service_name]</td> <td>$row[cfirst] $row[clast]</td><td>$row[timestamp]</td></tr>";
}
$blocks .= "</table>";
echo $blocks;