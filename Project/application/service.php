<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1C9060;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #286E51;
        }

        .center {
            text-align: center;
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

    if ($count == 0) {
        //echo "<h2 class='center'>Registration hasn't started yet!</h2>";
        //echo "<div class='center'><a href='start.html' class='button'>Return</a></div>";
        header("Location: start.html");
    } elseif ($count == 1) {
        //echo "<h2 class='center'>The competition has ended!</h2>";
        //echo "<div class='center'><a href='end.html' class='button'>Return</a></div>";
        header("Location: end.html");
    } elseif ($count == 2 && $now < $start) {
        //echo "<h2 class='center'>You can add compositions now!</h2>";
        //echo "<div class='center'><a href='add_composition.html' class='button'>Add Compositions</a></div>";
        header("Location: add_composition.html");
    } elseif ($count == 2 && $now >= $start && $now < $end) {
        //echo "<h2 class='center'>Registration is in progress!</h2>";
        //echo "<div class='center'><a href='registration_info.html' class='button'>Registration Info</a></div>";
        header("Location: registration_info.html");
    } elseif ($count == 2 && $now >= $end && $null > 0) {
        //echo "<h2 class='center'>Creating Schedule in Progress!</h2>";
        //echo "<div class='center'><a href='create_schedule_service.php' class='button'>Create Schedule</a></div>";
        header("Location: create_schedule_service.php");
    } elseif ($count == 2 && $now >= $end && $null == 0) {
        //echo "<h2 class='center'>Input Notes in Progress!</h2>";
        //echo "<div class='center'><a href='input_note.php' class='button'>Input Notes</a></div>";
        header("Location: input_note.php");
    }

    pg_close($link);
    ?>
</body>
</html>

