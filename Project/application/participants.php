<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirect Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #1C9060;
            color: #fff;
            padding: 10px;
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
            height: 100vh;
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
$now = date('Y-m-d H:i:s');
$result2 = pg_query($link, "select count(*) from mz430263.performance where which_one is null");
$null = pg_fetch_result($result2, 0, 0);

if ($count <= 1) {
    header("Location: entry_info.php");
    exit();
} elseif ($now < $start) {
    header("Location: entry_info.php");
    exit();
} elseif ($now >= $start && $now < $end) {
    header("Location: form.php");
    exit();
} elseif ($now >= $end && $null > 0) {
    header("Location: create_schedule_participants.php");
    exit();
} elseif ($now >= $end && $null == 0) {
    header("Location: schedule.php");
    exit();
}

pg_close($link);
?>
</body>
</html>

