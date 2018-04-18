<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 26/01/2018
 * Time: 09:58
 */
$ver = "Beta 1.0";
$servername = "localhost";
$username = "qnowwebsiteuser";
$password = "oa#RgV5p}&R-";
$dbname = "ess_database";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Successfully connected to database $dbname" . "<br />";
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}





function loginScript($em,$pass,$type,$conn){

    if ($type ==1){
        $login = "SELECT count(client_id) AS 'cli' FROM tbl_clients WHERE email='$em' AND password='$pass'";
    }else{

        $login = "SELECT count(staff_id) AS 'cli' FROM tbl_staff WHERE email='$em' AND password='$pass'";

    }
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

function getPref($conn, $u)
{
    $sql = "SELECT pref FROM tbl_clients WHERE email='$u'";
    foreach ($conn->query($sql) as $row) {
        $tim = $row[pref];

        return $tim;
    }
}



function changePref($conn,$rep,$u){

    $sql = "UPDATE tbl_clients SET pref=:pref WHERE email='$u'";
    $stmt = $conn->prepare($sql);
//Bind the provided username to our prepared statement.
    $stmt->bindValue(':pref',$rep);


//Execute.
    $stmt->execute();

}





function OpenClosedTickets($conn){
    $openClose="[
          ['Status', 'Value'],";
   $sql= "SELECT complete as comp, count(complete) as COU FROM tbl_ticket GROUP BY complete";
   foreach ($conn->query($sql) as $row){
       if ($row['comp']==0){
           $op="Open";
           $openClose .="['$op', $row[COU] ],";
       }else{
           $op="Closed";
           $openClose .="['$op', $row[COU] ]";
       }

   }
    $openClose .="";
   return $openClose;
}



function ServiceRatio($conn){
    $openClose="[['Service', 'Value'],";
    $sql= "SELECT s.service_name, count(t.service_id) AS COU FROM  tbl_ticket	t JOIN tbl_services s ON (t.service_id=s.serv_id) GROUP BY s.service_name";
    foreach ($conn->query($sql) as $row){
        $openClose .= "['$row[service_name]', $row[COU]],";


    }
    $openClose = substr($openClose, 0, -1);
    $openClose .="";
    return $openClose;
}


function StaffRatio($conn){
    $openClose="[['Service', 'Value'],";
    $sql= "SELECT s.first_name,s.last_name,COUNT(t.staff_id) AS COU FROM tbl_ticket t JOIN tbl_staff s ON (t.staff_id=s.staff_id) GROUP BY t.staff_id ORDER BY COUNT(t.staff_id) DESC";
    foreach ($conn->query($sql) as $row){
        $openClose .= "['$row[first_name] $row[last_name]', $row[COU]],";


    }
    $openClose = substr($openClose, 0, -1);
    $openClose .="";
    return $openClose;
}


function getRating($conn, $staff,$u){

    $rating=0;
    $ratings="";
    $sql= "SELECT client_id FROM tbl_clients WHERE email='$u'";
    foreach ($conn->query($sql) as $row){
        $client_id = $row[client_id];
    }
    $sql= "SELECT staff_id, AVG(rating) AS rat FROM tbl_ratings WHERE staff_id='$staff' GROUP BY staff_id";
    foreach ($conn->query($sql) as $row){
        $rating = $row['rat'];
        $staff=$row[staff_id];
    }
    $r =0;
    $maxRating=$rating;
    while ($rating >= 1) {
        $r += 1;
        $ratings .= "<a id='$r' onclick='ratingClicked($client_id,this.id,$staff)' class='ratingStars' onmouseover='changeStarColor(this.style.color, this)' onmouseout='changeBack(this)' style='color: black'  <span><i class='fas fa-star'></i></span></a>";
        $rating -= 1;
    }
    if ($rating != 0) {
        $r += 1;
        $ratings .= "<a id='$r' onclick='ratingClicked($client_id,this.id,$staff)' class='ratingStars' onmouseover='changeStarColor(this.style.color, this)' onmouseout='changeBack(this)'  style='color: black' > <span><i class='fas fa-star-half'></i></span></a>";

    }

    for ($i = round($maxRating, 0, PHP_ROUND_HALF_UP); $i < 5; $i++) {
        $r += 1;
        $ratings .= "<a id='$r' onclick='ratingClicked($client_id,this.id,$staff)' class='ratingStars' onmouseover='changeStarColor(this.style.color, this)' onmouseout='changeBack(this)' style='color: lightgrey'> <span><i class='fas fa-star'></i></span></a>";
    }
    return $ratings;
}













function shortestTimeStaff($conn,$service){
    $time_taken_sql = "SELECT staff_id, tt FROM(
    SELECT staff_id, sum(s.time_taken) AS tt FROM tbl_ticket t JOIN tbl_services s ON (s.serv_id=t.service_id) WHERE t.complete = 0 AND serv_id=$service GROUP BY staff_id
    UNION ALL
    SELECT staff_id,0 FROM tbl_staff WHERE serv_id='$service'
    ) a GROUP BY staff_id";
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