<?php
require 'connection.php';
session_start();
$u = $_SESSION['customerToken'];
$result = $conn->query("SELECT * FROM tbl_location l JOIN tbl_clients c ON (l.clientID=c.client_id) WHERE c.email = '$u' ");

$row = $result->fetch();
if($row == false){
    echo "<p>No address available</p>";
}
else{
    while($row != false){
        echo '<a class = "address" href="http://localhost:8888/ESS_project/pages/Customer_Dashboard.php?address='.$row[address].'">';
        echo "Address: $row[address]<br>";
        echo "Postcode: $row[postcode]<br>";
        echo '</a>';
        $row=$result->fetch();
    }
}

?>