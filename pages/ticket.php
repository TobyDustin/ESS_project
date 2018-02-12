<?php

$conn = new PDO("mysql:host=localhost;dbname=ess;","root","root");
$result = $conn->query("SELECT * FROM ticket WHERE service = 'window' ");

$row = $result->fetch();
if($row == false){
    echo "<p>No ticket available</p>";
}
else{
    while($row != false){
        echo '<div class = "tickets">';
        echo "<p>";
        echo "First Name: $row[firstName]<br>";
        echo "Second Name: $row[secondName]<br>";
        echo "Service: $row[service]<br>";
        echo "Address: $row[address]<br>";
        echo "</p>";
        echo '</div>';
        $row=$result->fetch();
    }
}

?>