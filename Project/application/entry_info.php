<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #1C9060;
            color: #fff;
            padding: 20px;
        }

        h2 {
            color: #1C9060;
        }

        center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 10vh;
        }

        input[type="submit"] {
            background-color: #1C9060;
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #286E51;
        }
    </style>
</head>
<body>
    <?php
    $link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
    $result = pg_query($link, "select count(*) from mz430263.announcement");
    $count = pg_fetch_result($result, 0, 0);
    $start = pg_query($link, "select deadline from mz430263.announcement where title = 'start'");
    $start = pg_fetch_assoc($start);
    $start = $start["deadline"];
    $end = pg_query($link, "select deadline from mz430263.announcement where title = 'end'");
    $end = pg_fetch_assoc($end);
    $end = $end["deadline"];
    ?>
    <h1>Registration hasn't started yet!</h1>
    <br>
    <?php
    if ($count >= 1) {
    ?>
    <center>
        <h2>Start:</h2>
        <?php
        echo $start . "<br>";
        }
        if ($count == 2) {
        ?>
        <h2>End:</h2>
        <?php
        echo $end . "<br>";
        }
        pg_close($link);
        ?>
    </center>
    <form action="homepage.html" method="post">
        <center>
            <input type="submit" value="Return"><br>
        </center>
    </form>
</body>
</html>

