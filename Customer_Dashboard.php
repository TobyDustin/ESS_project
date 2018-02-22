<?php
require 'connection.php';
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
  </head>
  <body>
      <div id="header">
          <h1>Header</h1>
      </div>
      <div id="nav">
      
      </div>
      <div id="main">
          <?php
          if (isset($_GET["address"]))
          {
              $a = $_GET["address"];
              $result = $conn->query("SELECT first_name,last_name,service_name,addressLine1 FROM tbl_ticket t JOIN tbl_clients c ON (t.client_id=c.client_id) JOIN tbl_services s ON (s.serv_id = t.service_id) JOIN tbl_location l ON (t.loc_id=l.loc_id) WHERE l.loc_id=$a");

              $row = $result->fetch();
              if($row == false){
                  echo "<p>No ticket available</p>";
              }
              else{
                  while($row != false){
                      echo '<div class = "tickets">';
                      echo "<p>";
                      echo "First Name: $row[first_name]<br>";
                      echo "Second Name: $row[last_name]<br>";
                      echo "Service: $row[service_name]<br>";
                      echo "Address: $row[addressLine1]<br>";
                      echo "</p>";
                      echo '</div>';
                      $row=$result->fetch();
                  }
              }
          }else{
              echo "<h>Welcome</h>";
          }

          ?>
      </div>
  </body>
</html>