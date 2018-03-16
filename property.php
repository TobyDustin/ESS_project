<?php
require 'connection.php';
session_start();
$u = $_SESSION['customerToken'];
$clientID = "SELECT client_id FROM tbl_clients WHERE email='$u'";
foreach ($conn->query($clientID) as $row) {
    $client_id= $row['client_id'];

}


$result = $conn->query("SELECT * FROM tbl_location l JOIN tbl_clients c ON (l.clientID=c.client_id) WHERE c.email = '$u' ");

$row = $result->fetch();
if($row == false){
    echo "<p>No address available</p>";
}
else{
    while($row != false){
        $client = $row[clientID];
        $addressLine1= $row[addressLine1];
        $row[addressLine1]=ucwords($row[addressLine1]);
        $row[postcode]= strtoupper($row[postcode]);
        echo '<a class = "address" href="Customer_Dashboard.php?address='.$addressLine1.'"><div class="addressDIV">';
        echo "$row[addressLine1]<br>";
        echo "$row[postcode]<br>";
        echo '</div></a>';
        $row=$result->fetch();
    }
    $addressLine1= $row[addressLine1];

}
echo '<div id="addNewProperty" style="text-align: center; font-size:24pt" class="addressDIV">';
echo "<button onclick='addProperty($client_id)' id='addButtonProp'>+</button><br>";
echo '</div>';

?>