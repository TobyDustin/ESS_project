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
              $result = $conn->query("SELECT * FROM tbl_ticket WHERE address = '$a' ");

              $row = $result->fetch();
              if($row == false){
                  echo "<p>No ticket available</p>";
              }
              else{
                  while($row != false){
                      echo '<div class = "tickets">';
                      echo "<p>";
                      echo "First Name: $row[firstName]<br>";
                      echo "Second Name: $row[lastName]<br>";
                      echo "Service: $row[service]<br>";
                      echo "Address: $row[address]<br>";
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