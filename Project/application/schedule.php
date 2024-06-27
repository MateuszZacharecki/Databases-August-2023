<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule</title>
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
        
        h1 {
            background-color: #1C9060;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #1C9060;
            color: #fff;
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
            min-height: 10vh;
        }
    </style>
</head>
<body>
<h1>Schedule of competition</h1>
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
<h1> Error: </h1>
<center>

<?php
echo pg_last_error($link) . "<br>";
?>
<p></p>
 <a href="participants.php" class="button">Return</a>
</center>
<?php
exit();
}
if ($now >= $end && $countWhichOne == 0) {
?>
<center>
<table>
  <tr>
    <th>No.</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Author</th>
<th>Title</th>
<th>Note</th>
  </tr>
<?php
$data = pg_query($link, "select which_one, Pianist_ID, Composition_ID, note from mz430263.performance 
order by which_one");
while($perform = pg_fetch_assoc($data)) {

$pianist = $perform["pianist_id"];
$composition = $perform["composition_id"];
$pianist_data = pg_query($link, "select first_name, last_name from mz430263.pianist 
where id = $pianist");
$pianist = pg_fetch_assoc($pianist_data);
echo "<td> {$perform["which_one"]}</td>";
echo "<td> {$pianist['first_name']}</td>";
echo "<td> {$pianist['last_name']}</td>";
$composition_data = pg_query($link, "select author, title from mz430263.composition 
where id = $composition");
$composition = pg_fetch_assoc($composition_data);
echo "<td> {$composition['author']}</td>";
echo "<td> {$composition['title']}</td>";
echo "<td> {$perform["note"]}</td>";
echo '</tr>';
}
?>
<p></p>
</table>
</center>
<?php
if ($countNote > 0)
{
?>
    <center>
    <a href="homepage.html" class="button">Return</a>
    </center>
<?php
}
}
else {
?>
<h1> Schedule hasn't been published yet! </h1>
<center>

<a href="homepage.html" class="button">Homepage</a>
</center>
<?php
exit();
}
if ($now >= $end && $countWhichOne == 0 && $countNote == 0) {
    ?>
    <h1> Results </h1>
    <center>
    
    <table>
      <tr>
        <th>First name</th>
        <th>Last name</th>
        <th>Final note</th>
      </tr>
    <?php 
    $final_data = pg_query($link, "select first_name, last_name, (select sum(note) 
    from mz430263.performance where pianist_id = pianist.id) as note from mz430263.pianist group by id 
    order by note desc");
    while($pianist = pg_fetch_assoc($final_data)) {

        echo "<tr>";
        echo "<td> {$pianist['first_name']}</td>";
        echo "<td> {$pianist['last_name']}</td>";
        echo "<td> {$pianist["note"]}</td>";
        echo '</tr>';
    }
    ?>
    </table>
    <a href="homepage.html" class="button">Return</a>
    </center>
    <?php
    exit();
}
pg_close($link);
?>
</body>
</html>

