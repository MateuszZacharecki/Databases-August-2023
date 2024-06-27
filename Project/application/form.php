<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
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
        
        form {
            width: 300px;
            height: 650px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        center {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 10vh;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
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
    ?>
    <h1>Registration</h1>
    <center>
        <h2>Time of registration's ending:</h2>
        <?php
        echo $end . "<br>";
        ?>
    </center>
    <?php
    if (!$link) {
        die("Database connection failed: " . pg_last_error());
    }

    function generateCompositionOptions($data) {
        while ($composition = pg_fetch_assoc($data)) {
            $pom = $composition['author'] . " - '" . $composition['title'] . "'";
            echo "<option value='{$composition['id']}'>{$pom}</option>";
        }
    }
    ?>
    <br>
    
    <form action="form_back.php" method="post">
        <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <center>
            <h2>Input your data!</h2>
            First name: <input type="text" name="first"><br>
            Last name: <input type="text" name="last"><br>
            First composition:
            <select name="com1">
                <?php
                $data = pg_query($link, "SELECT * FROM mz430263.composition");
                generateCompositionOptions($data);
                ?>
            </select><br>
            Second composition:
            <select name="com2">
                <?php
                $data = pg_query($link, "SELECT * FROM mz430263.composition");
                generateCompositionOptions($data);
                ?>
            </select><br>
            Third composition:
            <select name="com3">
                <?php
                $data = pg_query($link, "SELECT * FROM mz430263.composition");
                generateCompositionOptions($data);
                ?>
            </select><br>
            <input type="submit" value="Submit"><br>
            <a href="homepage.html" class="button">Return</a>
        </center>
    </form>
    <center>
        
    </center>

    <?php
    pg_close($link);
    ?>
</body>
</html>

