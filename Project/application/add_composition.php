<?php
$author = $_POST["author"];
$title = $_POST["title"];
$empty = empty($author) || empty($title);
$link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
$start = pg_query($link, "select deadline from mz430263.announcement where title = 'start'");
$start = pg_fetch_assoc($start);
$start = $start["deadline"];
$now = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composition Submission</title>
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
        <?php if ($now < $start) {
            if ($empty) { ?>
                <h1>Error! Fill the gaps!</h1>
                <center>
                <a href="add_composition.html" class="button">Return</a>
                </center>
            <?php } else {
                $result = pg_query_params($link, "INSERT INTO mz430263.composition (author, title) VALUES ($1, $2)", array($author, $title));
                if ($result) {
                    header("Location: service.php");
                    exit();
                } else {
                ?>
                    <h1 class="error">Error:</h1>
                    <center>
                    <p><?php echo pg_last_error($link); ?></p>
                    <a href="add_composition.html" class="button">Return</a>
                    </center>
                <?php }
            }
        } else { ?>
            <h1>Error! Registration has already begun!</h1>
            <center>
            <a href="service.php" class="button">Return</a>
            </center>
        <?php } ?>
</body>
</html>

<?php
pg_close($link);
?>

