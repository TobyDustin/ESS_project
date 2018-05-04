<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 26/01/2018
 * Time: 09:59
 */




// trigger for login script
if (isset($_POST['signin'])) {
    $em = $_POST['email'];
    $pass = hash('SHA512', $_POST['pass']);
    // The 1 is for clients anything else will be for staff
    echo loginScript($em,$pass,1,$conn);

}
//------------------------------------------------



// trigger client sign up
if (isset($_POST['signup'])){
    $fist_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $pass = hash('SHA512', $_POST['pass']);
    $tel = $_POST['tel'];
    newClient($fist_name,$last_name,$email,$pass,$tel,$conn);
}

//------------------------------------------------


// trigger for adding location
if (isset($_POST['addPostcode'])) {
    $postcode = $_POST['postcode'];
    $addline = $_POST['addline'];
    $addline2 =$_POST['addline2'];
    $town = $_POST['town'];
    $county = $_POST['county'];
    $client_id = "1";
    newLocation($client_id,$postcode,$addline,$addline2,$town,$county,$conn);
}
//------------------------------------------------


// trigger for adding ticket

//displaying all services
$service="";
$service_sql = "SELECT service_name FROM tbl_services";
foreach ($conn->query($service_sql) as $items) {
    $text = $items['service_name'];
    $service .= "<option>$text</option>";
}
//------------------------------------------------


// lowest time taken algorythm

$time_taken_sql = "SELECT staff_id, sum(s.time_taken) AS tt FROM tbl_ticket t JOIN tbl_services s ON (s.serv_id=t.service_id) WHERE t.complete = 0 GROUP BY staff_id";
$shortestTime;
$shortest_id;
foreach ($conn->query($service_sql) as $list) {
$time_taken = $list['tt'];
$staff_id = $list['staff_id'];
if ($time_taken<$shortestTime){
    $shortestTime=$time_taken;
    $shortest_id=$staff_id;
}
}
return $shortest_id;



//------------