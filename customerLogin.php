<?php
require 'connection.php';
// trigger for login script
if (isset($_POST['signin'])) {
    $em = $_POST['email'];
    $pass = hash('SHA512', $_POST['pass']);

    // The 1 is for clients anything else will be for staff
    if (loginScript($em,$pass,1,$conn)){
        session_start();
        $_SESSION['customerToken']=$em;
        header('location: Customer_Dashboard.php');

    }else{
        echo "<script>alert('that username and password combination is not recognised');</script>";
    }
}

if (isset($_POST['signup'])){
    $fist_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $pass = hash('SHA512', $_POST['pass']);
    $tel = $_POST['tel'];
    newClient($fist_name,$last_name,$email,$pass,$tel,$conn);
}

?>

<html>
  <head>
    <meta charset="UTF-8">
    <title>Customer</title>
      <link rel="stylesheet" href="stylesheet.css" type="text/css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

        
<!--        <h1>Sign Up</h1>-->
<!--        <form>-->
<!--            <fieldset>-->
<!--            <legend>Enter Your Account Details Here</legend>-->
<!--        <label> First Name:</label> <input type = "text" name="FirstName"> <br>-->
<!--            -->
<!--            -->
<!--    <br> <label> Last Name: </label> <input type  = "text" name="LastName"> <br>-->
<!--            -->
<!--    <br> <label>Email Address:</label> <input type = "text" name="Email_Address"> <br>-->
<!--            -->
<!--    <br> <label>Confirm Email:</label> <input type = "text" name="Confirm_Email"> <br>-->
<!--            -->
<!--    <br> <label>Phone Number:</label> <input type = "text" name="PhoneNumber"> <br>-->
<!--    -->
<!--    -->
<!--    <br> <label>Password:</label> <input type = "Password" name="Password" minlength="8"> <br>-->
<!--            -->
<!--    <br> <label>Confirm Password:</label> <input type = "Password" name="Password_Confirm" minlength="8"> <br>-->
<!--                -->
<!--    <br> <input type="submit" value="SUBMIT">-->
<!--            -->
<!--            </fieldset>-->
<!--            -->
<!--            </form>-->
<!--            -->
<!--            -->
<!--            </div>-->
<!--            -->
<!--            -->
<!--<h1>Sign In</h1>-->
<!--    <form>-->
<!--        <fieldset>-->
<!--            <legend>Sign In </legend>-->
<!--       -->
<!--            -->
<!--    <br> <label>Email Address:</label> <input type = "text" name="Email_Address"> <br>-->
<!--            -->
<!--   -->
<!--    -->
<!--    <br> <label>Password:</label> <input type = "Password" name="Password" minlength="8"> <br>-->
<!--            -->
<!--    -->
<!--            -->
<!--    <br> <input type="submit" value="SUBMIT">-->
<!--            -->
<!--    </fieldset>-->
<!--    -->
<!--    </form>-->
<!--            -->
<!--            -->
<!--            -->
<!--    -->
<!--<body>-->
<!--  -->
<!--  </body>-->
<!--</div>-->
        <div class="container">
            <h1>Welcome Client</h1>
            <br />
            <h2>To use our service, please sign in first</h2>
            <br />
            <button id= "start" class="btn btn-primary btn-lg" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Sign In / Register</button>

            <br>

        </div>


        <!-- Modal -->
        <div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <br>
                    <div class="bs-example bs-example-tabs">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
                            <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
                        </ul>
                    </div>
                    <div class="modal-body">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade active in" id="signin">
                                <form class="form-horizontal" action="customerLogin.php" method="post">
                                    <fieldset>
                                        <!-- Sign In Form -->
                                        <!-- Text input-->
                                        <div class="control-group">
                                            <label class="control-label" for="userid">Email:</label>
                                            <div class="controls">
                                                <input required="" id="userid" name="email" type="text" class="form-control" placeholder="Email" class="input-medium" required>
                                            </div>
                                        </div>

                                        <!-- Password input-->
                                        <div class="control-group">
                                            <label class="control-label" for="passwordinput">Password:</label>
                                            <div class="controls">
                                                <input required="" id="passwordinput" name="pass" class="form-control" type="password" placeholder="Passsword" class="input-medium">
                                            </div>
                                        </div>


                                        <!-- Button -->
                                        <div class="control-group">
                                            <label class="control-label" for="signin"></label>
                                            <div class="controls">
                                                <button id="signinb" name="signin" class="btn btn-success">Sign In</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="signup">
                                <form class="form-horizontal" action="customerLogin.php" method="post">
                                    <fieldset>
                                        <!-- Sign Up Form -->
                                        <!-- Text input-->
                                        <div class="control-group">
                                            <label class="control-label" for="firstname">First Name:</label>
                                            <div class="controls">
                                                <input id="firstname" name="first_name" class="form-control" type="text" placeholder="Fistname" class="input-large" required>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="control-group">
                                            <label class="control-label" for="Emailc">Last Name:</label>
                                            <div class="controls">
                                                <input id="lastname" name="last_name" class="form-control" type="text" placeholder="Last Name" class="input-large" required>
                                            </div>
                                        </div>

                                        <!-- Password input-->
                                        <div class="control-group">
                                            <label class="control-label" for="password">Email:</label>
                                            <div class="controls">
                                                <input id="email" name="email" class="form-control" type="email" placeholder="Email" class="input-large" required>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="control-group">
                                            <label class="control-label" for="reenterEmail">Re-enter email:</label>
                                            <div class="controls">
                                                <input id="reenterEmail" class="form-control" name="reenterEmail" type="email" placeholder="Re-enter Email" class="input-large" required>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="control-group">
                                            <label class="control-label" for="reenterEmail">Telephone Number:</label>
                                            <div class="controls">
                                                <input id="tel" class="form-control" name="tel" type="tel" placeholder="Telephone" class="input-large" required>
                                            </div>
                                        </div>

                                        <!-- Password input-->
                                        <div class="control-group">
                                            <label class="control-label" for="password">password:</label>
                                            <div class="controls">
                                                <input id="password" name="pass" class="form-control" type="password" placeholder="Password" class="input-large" required>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="control-group">
                                            <label class="control-label" for="rePassword">Re-enter password:</label>
                                            <div class="controls">
                                                <input id="rePassword" class="form-control" name="rePassword" type="password" placeholder="Re-enter Password" class="input-large" required>
                                            </div>
                                        </div>


                                        <!-- Button -->
                                        <div class="control-group">
                                            <label class="control-label" for="confirmsignup"></label>
                                            <div class="controls">
                                                <button id="confirmsignup" name="signup" class="btn btn-success">Sign Up</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>

</html>