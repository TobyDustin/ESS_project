<?php

$conn = new PDO("mysql:host=localhost;dbname=ess;","root","root");
$result = $conn->query("SELECT * FROM property WHERE ownerName = 'shashank' ");

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