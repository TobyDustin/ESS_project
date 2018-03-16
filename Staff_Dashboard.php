<!DOCTYPE html>

<?php
require 'connection.php';

if (isset($_GET['comp'])){
    $id = $_GET['comp'];
    try {
        $sql = "UPDATE `tbl_ticket` SET `complete` = '1' WHERE `tbl_ticket`.`tick_id` = $id";
        // use exec() because no results are returned

        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    unset($_GET['comp']);
}


?>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
        $("document").ready(function(){
            $.get({
                url: "ticket.php",
                dataType: "text",
                success: function(data){
                    $("#main").html(data);
                }
            });
            
        });
    </script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="style.css">
      <style>
          body{
              text-align: center;
          }
          #main{

              display: table;
              margin: 0 auto;
          }
      </style>
  </head>
  <body>
      <div id="header">
          <h1>Header</h1>
      </div>
      <div id="main">
      </div>
  </body>
</html>