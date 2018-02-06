<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 26/01/2018
 * Time: 09:58
 */
$ver = "Beta 1.0";
$servername = "localhost";
$username = "test2";
$password = "";
$dbname = "ess_database";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Successfully connected to database $dbname" . "<br />";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}





function loginScript($em,$pass,$type,$conn){
    if ($type ==1){
        $table="tbl_clients";
        $select = "client_id";
    }else{
        $table="tbl_staff";
        $select = "staff_id";

    }

    $login = "SELECT count($select) AS 'cli' FROM $table WHERE email='$em' AND password='$pass'";

    foreach ($conn->query($login) as $loginCheck) {
        if ($loginCheck['cli']==1){
            return true;
        }else{

            return false;
        }
    }
    return false;
}



function newClient($fist_name,$last_name,$email,$pass,$tel,$conn){
    try {
        $sql = "INSERT INTO tbl_clients(first_name, last_name, email, password, tel_number) VALUES ('$fist_name','$last_name','$email','$pass','$tel')";
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}



function newLocation($client_id,$postcode,$addline,$addline2,$town,$county,$conn){
    try {
        $sql = "INSERT INTO tbl_location(clientID, postcode, addressLine1, addressLine2, addressLine3, Town, County) VALUES ('$client_id','$postcode','$addline','$addline2',NULL,'$town','$county')";
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

}




function shortestTimeStaff($conn){
    $time_taken_sql = "SELECT staff_id, sum(s.time_taken) AS tt FROM tbl_ticket t JOIN tbl_services s ON (s.serv_id=t.service_id) WHERE t.complete = 0 GROUP BY staff_id";
    $shortestTime=100000000000;
    $shortest_id=0;
    foreach ($conn->query($time_taken_sql) as $list) {
        $time_taken = $list['tt'];
        $staff_id = $list['staff_id'];
        if ($time_taken<$shortestTime){
            $shortestTime=$time_taken;
            $shortest_id=$staff_id;
        }
    }
    return $shortest_id;
}