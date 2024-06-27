<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Competition Start Time</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #1C9060;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            text-align: center;
            text-decoration: none;
            background-color: #1C9060;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
        }
        
        .button:hover {
            background-color: #286E51;
        }

        center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 10vh;
        }
    </style>
</head>
<body>
    <?php
    $start = $_POST["start"];
    $empty = empty($start);
    $link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
    $now = date('Y-m-d\TH:i');
    
    
    if ($empty) {
    ?>
    <h1>Error! Fill the gaps!</h1>
    <center>
        <a href="start.html" class="button">Return</a>
    </center>
    <?php
        exit();
    }
    
    if ($start <= $now) {
    ?>
    <h1>Error! The competition cannot end before it starts!</h1>
    <center>
        <a href="start.html" class="button">Return</a>
    </center>
    <?php
        exit();
    } else {
        $result = pg_query($link, "insert into mz430263.announcement values ('start','$start')");
        if ($result) {
    ?>
    <?php
            header("Location: service.php");
            exit();
        } else {
    ?>
    <h1>Error:</h1>
    <center>
        <?php
            echo pg_last_error($link);
        ?>
        <p></p>
        <a href="start.html" class="button">Return</a>
    </center>
    <?php
        }
    }
    
    pg_close($link);
    ?>
</body>
</html>


