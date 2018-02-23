<?php
require 'connection.php';

session_start();
$u = $_SESSION['staffToken'];
$result = $conn->query("SELECT t.tick_id,c.first_name,c.last_name,c.email,s.service_name,l.addressline1,l.postcode FROM tbl_ticket t JOIN tbl_clients c ON (t.client_id=c.client_id) JOIN tbl_services s ON (t.service_id=s.serv_id) JOIN tbl_location l ON (t.loc_id=l.loc_id) JOIN tbl_staff a ON (t.staff_id=a.staff_id) WHERE a.email='$u' ");

$row = $result->fetch();
if($row == false){
    echo "<p>No ticket available</p>";
}
else{
    while($row != false){
        $row[first_name] = ucfirst($row[first_name]);
        $row[last_name] = ucfirst($row[last_name]);
        $dateCompleted ="Your repair was completed at: ". date("H:i:s Y/m/d");
        echo '<div class = "tickets">';
        echo "<p>";
        echo "First Name: $row[first_name]<br>";
        echo "Second Name: $row[last_name]<br>";
        echo "Service: $row[service_name]<br>";
        echo "Address:<a target='_blank' href='https://maps.google.com/maps?q=$row[addressline1] $row[postcode]'>Get Directions</a><br>";
        echo "Email:<a target='_top' href='mailto:$row[email]?Subject=Repair From $row[first_name] $row[last_name] has been completed.&Body=$dateCompleted %0D%0A Your service was: $row[service_name]'>Email</a><br>";
        echo "<form action='Staff_Dashboard.php'> <button name='comp' value='$row[tick_id]' onclick='this.form.submit()'>Complete</button></form>";
        echo "</p>";
        echo '</div>';
        $row=$result->fetch();
    }
}

?>