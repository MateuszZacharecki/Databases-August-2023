<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Verification</title>
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
            background-color: #1C9060;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 3px;
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
$username = $_POST["username"];
$password = $_POST["password"];

$link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
$result = pg_query_params($link,
                         "SELECT count(*)
                          FROM mz430263.Service
                          WHERE login = $1 AND password = $2",
                          array($username, $password));
$count = pg_fetch_result($result, 0, 0);

if ($count == 0) {
?>  
    <h1>Access Refusal</h1>
<center>
    <a href="#" class="button" onclick="history.back()">Return</a>
</center>
<?php
} else {
    header("Location: service.php");
    exit();
}

pg_close($link)
?>
</body>
</html>

