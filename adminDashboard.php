<?php
/**
 * Created by PhpStorm.
 * User: tobydustin
 * Date: 15/03/2018
 * Time: 15:43
 */
require"connection.php"
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
                <li><a data-toggle="tab" href="#changeStaff">Change Staff Member</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Services<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a data-toggle="tab" href="#addServ">Add Service</a></li>
                <li><a data-toggle="tab" href="#deleteServ">Delete Service</a></li>
                <li><a data-toggle="tab" href="#changeServ">Change Service</a></li>
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
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="deleteStaff" class="tab-pane fade">
            <h3>Delete Staff Member</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="changeStaff" class="tab-pane fade">
            <h3>Change Staff Member</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>



        <div id="addServ" class="tab-pane fade">
            <h3>Add Service </h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="deleteServ" class="tab-pane fade">
            <h3>Delete Service </h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="changeServ" class="tab-pane fade">
            <h3>Change Service</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>







    </div>
</div>
<div class="liveFeed" id="liveFeed">

    blah

</div>
</body>
</html>
