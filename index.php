<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 26/01/2018
 * Time: 09:58


**/

require 'connection.php';


if (isset($_POST['signup'])){
    $fist_name = $_POST['fn'];
    $last_name = $_POST['ln'];
    $email = $_POST['email'];
    $pass = hash('SHA512', $_POST['pass']);
    $tel = $_POST['tel'];
    newClient($fist_name,$last_name,$email,$pass,$tel,$conn);
}


if (isset($_POST['signin'])) {
    echo "<script>alert('success');</script>";
    $em = $_POST['email'];
    $pass = hash('SHA512', $_POST['pass']);
    // The 1 is for clients anything else will be for staff
    echo loginScript($em,$pass,1,$conn);

}
echo shortestTimeStaff($conn);
?>
<html>
<head>

</head>
<body>
<h3>Login - Staff</h3>
<form action="index.php">
    <label for="email">Email</label><br/>
    <input type="email" name="email"><br />
    <label for="pass">Password</label><br />
    <input type="password" name="pass"><br />

    <input type="submit" name="signin">
</form>
<hr>


<h3>Login - client</h3>
<form action="index.php" method="post">
    <label for="email">Email</label><br/>
    <input type="email" name="email"><br />
    <label for="pass">Password</label><br />
    <input type="password" name="pass"><br />
    <input type="submit" name="signin">
</form>
<hr>



<h3>Client Signup</h3>
<form action="index.php" method="post">
    first name <br />
    <input type="text" name="fn" required><br />
    last name<br />
    <input type="text" name="ln" required><br />
    email<br />
    <input type="email" name="email" required><br />
    password<br />
    <input type="password" name="pass" required><br />
    telephone number<br />
    <input type="tel" name="tel" required><br />
    <input type="submit" name="signup">

</form>
<hr>

<h3>Add Location</h3>
<form action='index.php' method='post'>
    <label for='postcode'>Address</label>
    <br />
    <input id='postcod' name='postcode' placeholder='Postcode' type='text'  value='' width='400' required>
    <input id='number' name='number' placeholder='House #' type='text' width='100' required>
    <button type='button' id='findAddress'>Find</button>
    <br />
    <br />
    <input id='addressline' class='address' name='addline' placeholder='Address Line 1' type='text' width='400'>
    <br />
    <input id='addressline2' class='address' name='addline2' placeholder='Address Line 2' type='text' width='400'>
    <br />
    <input id='town' class='address' name='town' placeholder='Town' type='text' width='400'>
    <br />
    <input id='county' class='address' name='county' placeholder='County' type='text' width='400'>
    <br />
    <input id='postcode' class='address' name='postcode' placeholder='Postcode' type='text' width='400'>

    <input type='submit' value='add'>
</form>
</body>
<hr>
<select>
    <?php echo $service;?>
</select>
<hr>











<script
    src="http://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
<script>
    $('#findAddress').click(function(){
        //Get Postcode
        var number = $('#number').val();
        var postcode = $('#postcod').val().toUpperCase();

        //Get latitude & longitude
        $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' + postcode + '&sensor=false',
            function(data) {
                var lat = data.results[0].geometry.location.lat;
                var lng = data.results[0].geometry.location.lng;

                //Get address
                $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=false',
                    function(data) {
                        var address = data.results[0].address_components;
                        var street = address[1].long_name;
                        var town = address[2].long_name;
                        var county = address[4].long_name;

                        //Insert
                        $('#addressline').val(number +' ' +street);
                        $('#town').val(town);
                        $('#county').val(county);
                        $('#postcode').val(postcode);
                    });
            });
    });
</script>


</html>