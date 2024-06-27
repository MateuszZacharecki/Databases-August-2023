<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Note</title>
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

        center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 30vh;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            text-align: center;
        }

        th {
            background-color: #1C9060;
            color: #fff;
        }

        input[type="number"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"], .button {
            background-color: #1C9060;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 10px;
            font-size: 16px;
        }

        input[type="submit"]:hover, .button:hover {
            background-color: #286E51;
        }
    </style>
</head>
<body>
<?php
$link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
$end = pg_query($link, "select deadline from mz430263.announcement where title = 'end'");
$end = pg_fetch_assoc($end);
$end = $end["deadline"];
$now = date('Y-m-d H:i:s');
$resultWhichOne = pg_query($link, "select count(*) from mz430263.performance where which_one is null");
$countWhichOne = pg_fetch_assoc($resultWhichOne);
$countWhichOne = $countWhichOne["count"];
$resultNote = pg_query($link, "select count(*) from mz430263.performance where note is null");
$countNote = pg_fetch_assoc($resultNote);
$countNote = $countNote["count"];
if (!$resultWhichOne || !$resultNote) {
?>
<center>
<h2>Error:</h2>
<?php
echo pg_last_error($link) . "<br>";
?>
<p></p>
<a href="homepage.html" class="button">Return</a>
</center>
<?php
exit();
}
if ($now >= $end && $countWhichOne == 0 && $countNote > 0) {
?>
<form action="note.php" method="post">
<h1>Input note</h1>
<center>

<table>
    <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Author</th>
        <th>Title</th>
        <th>Note</th>
    </tr>
    <?php
    $data = pg_query($link, "select Pianist_ID, Composition_ID, ID from mz430263.performance WHERE which_one = (SELECT min(which_one) FROM mz430263.performance where note is null)");
    while($perform = pg_fetch_assoc($data)) {
        $pianist = $perform["pianist_id"];
        $composition = $perform["composition_id"];
        $id = $perform["id"];
        $pianist_data = pg_query($link, "select first_name, last_name from mz430263.pianist where id = $pianist");
        $pianist = pg_fetch_assoc($pianist_data);
        $composition_data = pg_query($link, "select author, title from mz430263.composition where id = $composition");
        $composition = pg_fetch_assoc($composition_data);
        ?>
        <tr>
            <td><?php echo $pianist['first_name']; ?></td>
            <td><?php echo $pianist['last_name']; ?></td>
            <td><?php echo $composition['author']; ?></td>
            <td><?php echo $composition['title']; ?></td>
            <td><input type="number" name="note" min="0" max="6" step="0.1"><br></td>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        </tr>
        <?php
    }
    ?>
</table>
<br>
<input type="submit" value="Submit"><br>
<a href="homepage.html" class="button">Return</a>
</center>
</form>
<?php
exit(); 
}
elseif ($now >= $end && $countWhichOne == 0 && $countNote == 0) {
?>
<h1>All notes have been input!</h1>
<center>

<a href="homepage.html" class="button">Return</a>
</center>
<?php
exit(); 
}
else {
?>
<h1>Schedule hasn't been published yet!</h1>
<center>
<a href="homepage.html" class="button">Return</a>
</center>
<?php
exit(); 
}
pg_close($link);
?>
</body>
</html>

