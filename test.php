<?php
require 'connection.php';


if (isset($_POST['text'])) {
    $t = $_POST['text'];
    $t = explode(" ", $t);
    for ($i = 0; $i < sizeof($t); $i++) {
        $j = ucfirst($t[$i]);
        $sql = "INSERT INTO words(word) VALUES ('$j')";
        // use exec() because no results are returned
        $conn->exec($sql);
    }
    $whole = 0;
    $z = '';

    $sql = "SELECT count(*) AS i FROM words";
    foreach ($conn->query($sql) as $list) {
        $whole = $list['i'];
    }

    $sql = "SELECT count(id) AS i, word FROM words GROUP BY word ORDER BY count(id) ASC";
    foreach ($conn->query($sql) as $list) {
        $c = $list['i'];
        $p = (($whole/$c)*10);
        $w = $list['word'];
        $z .= "<p style='font-size: $p%;margin-top: 0;padding-top: 0;margin-bottom: 0'>$w</p>";

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
    <title>Document</title>
</head>
<body>
    <form action="test.php" method="POST">
        <textarea name="text" onblur="this.form.submit()"></textarea>

        <?php
            echo $z;
        ?>

    </form>
</body>
</html>
