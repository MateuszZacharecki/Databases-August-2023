<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Note</title>
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
            padding: 15px 30px;
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
$id = $_POST["id"];
$note = $_POST["note"];
$empty = empty($id);

$link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
$result = pg_query($link, "update mz430263.performance set note = $note where id = $id");

if($empty) {
?> 
<h1>Error! Fill the gaps!</h1>
<center>
    
    <a href="input_note.php" class="button">Return</a>
</center>
<?php
exit();
}

if (!$result) {
?>
<h1>Error:</h1>
<center>
    
    <?php echo pg_last_error($link); ?>
    <p></p>
    <a href="input_note.php" class="button">Return</a>
</center>
<?php
exit();
} else {
    $resultNote = pg_query($link, "select count(*) from mz430263.performance where note is null");
    $countNote = pg_fetch_assoc($resultNote);
    $countNote = $countNote["count"];

    if (!$resultNote) {
?>
<h1>Error:</h1>
<center>
    
    <?php echo pg_last_error($link); ?>
    <p></p>
    <a href="input_note.php" class="button">Return</a>
</center>
<?php
exit();
}

if ($countNote == 0) {
?>
<h1>All notes have been input!</h1>
<center>
    
    <a href="homepage.html" class="button">Homepage</a>
</center>
<?php
exit(); 
} else {
?>
<h1>The note has been input!</h1>
<center>
    
    <a href="input_note.php" class="button">Return</a>
</center>
<?php
exit(); 
}
exit();
}

pg_close($link);
?>
</body>
</html>

