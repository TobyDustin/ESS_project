<!DOCTYPE html>
<html>
  <head>
    <title>Customer_Dashboard</title>
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
      
  </body>
</html>