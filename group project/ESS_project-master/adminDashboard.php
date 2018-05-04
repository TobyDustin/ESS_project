<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 15/03/2018
 * Time: 15:43
 */
require"connection.php";

if (isset($_GET['addService'])){
    $serviceName = $_GET['serviceName'];
    $time_taken= $_GET['timeTaken'];
    $cost = $_GET['cost'];

    try {
        $sql = "INSERT INTO tbl_services(service_name, time_taken, cost) VALUES ('$serviceName','$time_taken','$cost')";
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}
if (isset($_GET['delService'])){
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM `tbl_services` WHERE serv_id='$id'";
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

if (isset($_GET['addStaff'])){
    $serviceName = $_GET['serviceName'];
    $time_taken= $_GET['timeTaken'];
    $cost = $_GET['cost'];

    try {
        $sql = "INSERT INTO tbl_services(service_name, time_taken, cost) VALUES ('$serviceName','$time_taken','$cost')";
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

if (isset($_GET['delStaff'])){
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM `tbl_services` WHERE serv_id='$id'";
        // use exec() because no results are returned
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}




?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <style>
        .adminMenu{
            width: 35vw;
            float: left;
            height: 88vh;
            overflow: scroll;
        }
        .liveFeed{
            float: right;
            width: 57vw;
            height: 80vh;
            overflow: scroll;
            margin-right: 1vw;
            background-color: #81898f;
        }
        .tableLive{
            width:100%;
            font-size: 18pt;

        }
        .tableLive th{
            background-color: #cbc7c7;
            text-align: center;
        }
        .tableLive td{
            padding-top: 20px;
            background-color: #e8e4e4;
            border-bottom: solid 2px;

        }
    </style>
    <script>
        function showLive() {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("liveFeed").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "adminAJAX.php?", true);
                xmlhttp.send();
            }
    </script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart(title) {

            var options = {
            };

            var chart = new google.visualization.PieChart(document.getElementById('tickChart'));
            var data = google.visualization.arrayToDataTable(<?php echo OpenClosedTickets($conn) ?>]);
            chart.draw(data, options);

            var tickChart = new google.visualization.PieChart(document.getElementById('servChart'));
            var servdata = google.visualization.arrayToDataTable(<?php echo ServiceRatio($conn) ?>]);
            tickChart.draw(servdata, options);

            var staffChart = new google.visualization.PieChart(document.getElementById('staffChart'));
            var staffData = google.visualization.arrayToDataTable(<?php echo StaffRatio($conn) ?>]);
            staffChart.draw(staffData, options);
        }
    </script>


</head>
<body onload="showLive()">
<header>
    <h1>Header</h1>
</header>

<div class="container adminMenu">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Reports</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Staff<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a data-toggle="tab" href="#addStaff">Add Staff Member</a></li>
                <li><a data-toggle="tab" href="#deleteStaff">Delete Staff Member</a></li>

            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Services<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a data-toggle="tab" href="#addServ">Add Service</a></li>
                <li><a data-toggle="tab" href="#deleteServ">Delete Service</a></li>
            </ul>
        </li>
    </ul>

    <div class="tab-content adminMenu">
        <div id="home" class="tab-pane fade in active">
            <h3>Reports</h3>

            <p>Open to Closed Ticket Ratio</p>
            <div id="tickChart" style="width: 80%; height: 350px;"></div>

            <p>Service Ratio</p>
            <div id="servChart" style="width: 80%; height: 350px;"></div>

            <p>Staff Ratio</p>
            <div id="staffChart" style="width: 80%; height: 350px;"></div>

        </div>


        <div id="addStaff" class="tab-pane fade">
            <h3>Add Staff Member</h3>

            <form action="adminDashboard.php" method="get">
                <label for="edt_stafffirst_Name">Staff First Name</label><br />
                <input id="edt_stafffirst_Name" name="edt_stafffirst_Name" type="text"><br />
                <br />

                <label for="edt_stafflast_Name">Staff Last Name</label><br />
                <input id="edt_stafflast_Name" name="edt_stafflast_Name" type="text"><br />
                <br />

                <label for="edt_email">Email</label><br />
                <input id="edt_email" name="edt_email" type="email"><br />
                <br />

                <label for="edt_password">Password</label><br />
                <input id="edt_password" name="edt_password" type="password" ><br />
                <br />

                <label for="edt_telephone">Telephone Number</label><br />
                <input id="edt_telephone" name="edt_telephone" type="text" ><br />
                <br />

                <label for="edt_admin">Admin</label>
                <input id="edt_admin" name="edt_admin" type="checkbox" ><br />
                <br />
                    <label for="edt_staffADD">Search Service:</label><br />
                    <input id="edt_staffADD" type="text" oninput="textsearch('addStaff',this.value)">
                    <div id="dynam"></div>
                <br />

                <input type="submit" name="addStaff">

            </form>


        </div>


        <div id="deleteStaff" class="tab-pane fade">
            <h3>Delete Staff Member</h3>

            <label for="edt_staffDEL">Search Service:</label><br />
            <input id="edt_staffDEL" type="text" oninput="textsearch('delStaff',this.value)">
            <div id="dynam"></div>

        </div>




        <div id="addServ" class="tab-pane fade">
            <h3>Add Service </h3>
            <p>
                <form action="adminDashboard.php" method="get">
                <label for="edt_serviceName">Service Name</label><br />
                <input id="edt_serviceName" name="serviceName" type="text"><br />
                <br />

                <label for="edt_timeTaken">Time Taken (minutes)</label><br />
                <input id="edt_timeTaken" name="timeTaken" type="number"><br />
                <br />

                <label for="edt_cost">Cost (£)</label><br />
                <input id="edt_cost" name="cost" type="number" step="any"><br />
                <br />

                <input type="submit" name="addService">

            </form>
            </p>
        </div>
        <div id="deleteServ" class="tab-pane fade">
            <h3>Delete Service </h3>
            <label for="edt_serviceNameDEL">Search Service:</label><br />
            <input id="edt_serviceNameDEL" type="text" oninput="textsearch('delServ',this.value)">
            <div id="dynam"></div>


        </div>






    </div>
</div>
<div class="liveFeed" id="liveFeed">

    blah

</div>
</body>
</html>
