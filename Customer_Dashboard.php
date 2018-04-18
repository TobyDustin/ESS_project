<?php
require 'connection.php';
session_start();

$u="";
if (isset($_SESSION['customerToken'])){
    $u = $_SESSION['customerToken'];
}else{
    header('location: index.php');
}

$pref = getPref($conn,$u);
$rating ="";
$time="";
if ($pref==0){
    $rating = "checked='checked'";
}else{
    $time = "checked='checked'";
}


if (isset($_GET['pref_select'])){
    $select = $_GET['pref_select'];
    if (($select==1) || ($select==0)){
         changePref($conn,$select,$u);
    }else{
        $_GET['pref_select']=-1;
    }

}



if (isset($_POST['sub'])){
    // script for adding product
    $sql = "INSERT INTO `tbl_location`(`clientID`, `postcode`, `addressLine1`,`Town`, `County`) VALUES (:id,:postcode,:address,:town,:county)";
    $stmt = $conn->prepare($sql);
//Bind the provided username to our prepared statement.
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->bindValue(':postcode', $_POST['postcode']);
    $stmt->bindValue(':address',$_POST['address']);
    $stmt->bindValue(':town',$_POST['town']);
    $stmt->bindValue(':county',$_POST['county']);

//Execute.
    $stmt->execute();
//enter code here
}
if (isset($_POST['newTick'])){

    $add_id = $_POST['addressID'];
    $client_id = $_POST['ident'];
    $repeat = $_POST['repeat'];
    $service = $_POST['serv'];
    $staff_id= shortestTimeStaff($conn,$service);

    $sql = "INSERT INTO `tbl_ticket`(`client_id`, `loc_id`, `service_id`, `staff_id`, `repeat_time`) VALUES (:client_id,:loc_id,:service,:staff_id,:repeat)";
    $stmt = $conn->prepare($sql);

//Bind the provided username to our prepared statement.
    $stmt->bindValue(':client_id',$client_id);
    $stmt->bindValue(':loc_id', $add_id);
    $stmt->bindValue(':service',$service);
    $stmt->bindValue(':staff_id',$staff_id);
    $stmt->bindValue(':repeat',$repeat);

//Execute.
    $stmt->execute();
//enter code here

}


$newJobFrom="";
$service = "SELECT serv_id, service_name FROM tbl_services";
foreach ($conn->query($service) as $row) {
    $newJobFrom .= "<option value='$row[serv_id]'>$row[service_name]</option>";
}
$m = $_SESSION['customerToken'];
$id="";
$idSQL = "SELECT client_id FROM tbl_clients WHERE email='$m'";
foreach ($conn->query($idSQL) as $rowID) {
    $id = $rowID['client_id'];
}
$a = $_GET["address"];
$loc_id="";
$idSQL = "SELECT loc_id FROM tbl_location WHERE addressLine1='$a'";
foreach ($conn->query($idSQL) as $rowID) {
    $loc_id = $rowID['loc_id'];
}
$radioButtons="";
$radioButtons .= "<input type='text' name='addressID' value='$loc_id' hidden><input type='text' name='ident' value='$id' hidden><input type='radio' name='repeat' value='0'>None<br /><input type='radio' name='repeat' value='1'>Daily<br /><input type='radio' name='repeat' value='2'>Weekly<br /><input type='radio' name='repeat' value='3'>Yearly<br />";

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Customer_Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $("document").ready(function(){
            $.get({
                url: "property.php",
                dataType: "text",
                success: function(data){
                    $("#nav").html(data);
                }
            });
        });
    </script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
      <script src="script.js"></script>
      <script>
          function newJob() {
              var e = document.getElementById("newProblem");
              e.style.fontSize= "12pt";
              e.innerHTML= "<form action='Customer_Dashboard.php' method='post'><select name='serv'><?php echo $newJobFrom; ?></select><br /><?php echo $radioButtons; ?><input type='submit' name='newTick' value='book'></form>";

          }
      </script>
      <link rel="stylesheet" href="style.css">

  </head>
  <body>
      <div id="header">
          <h1>Customer Page</h1>
            <div class="preference">
                <h3>Contractor Preference</h3>
                <form action="Customer_Dashboard.php" method="get">
                    <h4><label for="highest">Highest Rated</label><input type="radio" id="highest"  name="pref_select" value="0" onclick="this.form.submit()" <?php echo $rating; ?><label for="lowest">Lowest Time</label><input type="radio" name="pref_select" id="lowest" onclick="this.form.submit()" <?php echo $time; ?> value="1" ></h4>
                </form>
            </div>


      </div>
      <div id="nav">
      
      </div>
      <div id="main">
          <?php
          if (isset($_GET["address"]))
          {
              $a = $_GET["address"];
              session_start();
              $u = $_SESSION['customerToken'];

              $result = $conn->query("SELECT t.staff_id, a.first_name,a.last_name,service_name,t.timestamp,l.addressLine1,l.postcode,t.complete FROM tbl_ticket t JOIN tbl_clients c ON (t.client_id=c.client_id) JOIN tbl_services s ON (s.serv_id = t.service_id) JOIN tbl_location l ON (t.loc_id=l.loc_id) JOIN tbl_staff a ON (t.staff_id=a.staff_id) WHERE l.addressLine1='$a' AND c.email='$u' AND complete=0 ORDER BY complete ASC");

              $row = $result->fetch();
              if($row == false){
                  echo "<p>No ticket available</p>";
              }
              else{
                  while($row != false){
                      $first_name = ucfirst($row[first_name]);
                      $last_name = ucfirst($row[last_name]);

                      echo '<div class = "tickets">';
                      echo "<p>";
                      echo "<b>$row[service_name]</b><br>";
                      echo "<hr>";
                      echo "$first_name ";
                      echo "$last_name<br>";
                      echo "$row[timestamp]<br>";
                      echo "<hr>";
                      $staff = $row[staff_id];
                      echo getRating($conn, $staff,$u);
                      echo "</p>";
                      echo '</div>';
                      $row=$result->fetch();
                  }
              }
          }else{
              echo "<h>Welcome</h>";
          }
          if (isset($_GET["address"])) {
              echo '<div class = "tickets" id="newProblem" style="text-align: center">';
              echo "";
              echo "<button style='width: 100%; height:110px; font-size: 36pt;background-color: transparent;border: none' onclick='newJob()'>+</button><br>";

              echo '</div>';
          }
          ?>
      </div>
  </body>
</html>