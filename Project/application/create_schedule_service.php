<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 10vh;
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
    </style>
</head>
<body>
    <?php
    $link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
    $result = pg_query($link, "select max(id) from mz430263.performance");
    if (!$result) {
    ?>
    <h1>Error:</h1>
    <center>
        
        <?php
        echo pg_last_error($link) . "<br>";
        ?>
        <p></p>
        <a href="homepage.html" class="button">Return</a>
    </center>
    <?php
        exit();
    }
    $max = pg_fetch_result($result, 0, 0);
    $k = 1;
    for ($i = 1; $i <= 3; $i++) {
        for ($j = $i; $j <= $max; $j = $j + 3) {
            $update = pg_query($link, "update mz430263.performance set which_one = '$k' where id = '$j'");
            $k = $k + 1;
            if (!$update) {
    ?>
    <h1>Error:</h1>
    <center>

        <?php
        echo pg_last_error($link) . "<br>";
        ?>
        <p></p>
        <a href="homepage.html" class="button">Return</a>
    </center>
    <?php
                exit();
            }
        }
    }
    header("Location: input_note.php");
    pg_close($link);
    ?>
</body>
</html>

