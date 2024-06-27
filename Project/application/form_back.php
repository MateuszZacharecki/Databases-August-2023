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
            padding: 15px 30px;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        input[type="submit"]:hover, .button:hover {
            background-color: #286E51;
        }
    </style>
</head>
<body>
    <?php
    $first = $_POST["first"];
    $last = $_POST["last"];
    $com1 = $_POST["com1"];
    $com2 = $_POST["com2"];
    $com3 = $_POST["com3"];
    $empty = empty($first) || empty($last) || empty($com1) || empty($com2) || empty($com3);
    $link = pg_connect("host=lkdb dbname=mrbd user=scott password=tiger");
    $start = pg_query($link, "select deadline from mz430263.announcement where title = 'start'");
    $start = pg_fetch_assoc($start);
    $start = $start["deadline"];
    $end = pg_query($link, "select deadline from mz430263.announcement where title = 'end'");
    $end = pg_fetch_assoc($end);
    $end = $end["deadline"];
    $now = date('Y-m-d H:i:s');
    
    if ($now >= $start && $now < $end) {
        if ($empty) {
    ?>
        <h1>Error! Fill the gaps!</h1>
        <center>
            
            <a href="form.php" class="button">Return</a>
        </center>
    <?php
        exit();
        }
    
        $check1 = pg_query($link, "select author from mz430263.Composition where ID = '$com1'");
        $check1 = pg_fetch_assoc($check1);
        $check2 = pg_query($link, "select author from mz430263.Composition where ID = '$com2'");
        $check2 = pg_fetch_assoc($check2);
        $check3 = pg_query($link, "select author from mz430263.Composition where ID = '$com3'");
        $check3 = pg_fetch_assoc($check3);
        $check = ($check1["author"] == $check2["author"]) ||  
        ($check1["author"] == $check3["author"]) ||  
        ($check2["author"] == $check3["author"]);
    
        if ($check) {
    ?> 
        <h1>Error! You can't choose compositions of the same author!</h1>
        <center>
            <a href="form.php" class="button">Return</a>
        </center>
    <?php
        exit();
        }
    
        $result = pg_query($link, "insert into mz430263.pianist (first_name, last_name)
                                          values ('$first', '$last') returning id");
        $result = pg_fetch_assoc($result);
    
        if ($result) {
            $result = $result["id"];
            $count1 = pg_query($link, "select count(*) from mz430263.performance where Pianist_ID = '$result'");
            $count1 = pg_fetch_result($count1, 0, 0);
    
            if ($count1 < 3) {
            $result1 = pg_query($link, "insert into mz430263.performance(Pianist_ID, Composition_ID) values ('$result', '$com1')");
    
            if (!$result1) {
    ?>
                <h1>Error:</h1>
                <center>
                    
                    <?php
                    echo pg_last_error($link) . "<br>";
                    ?>
                    <p></p>
                    <a href="form.php" class="button">Return</a>
                </center>
    <?php
                exit();
            }
    }
            $count2 = pg_query($link, "select count(*) from mz430263.performance where Pianist_ID = '$result'");
            $count2 = pg_fetch_result($count2, 0, 0);
    
            if ($count2 < 3) {
                $result2 = pg_query($link, "insert into  mz430263.performance(Pianist_ID, Composition_ID) values ('$result', '$com2')");
    
                if (!$result2) {
    ?>
                    <h1>Error:</h1>
                    <center>
                        
                        <?php
                        echo pg_last_error($link) . "<br>";
                        ?>
                        <p></p>
                        <a href="form.php" class="button">Return</a>
                    </center>
    <?php
                    exit();
                }
            }
    
            $count3 = pg_query($link, "select count(*) from mz430263.performance where Pianist_ID = '$result'");
            $count3 = pg_fetch_result($count3, 0, 0);
    
            if ($count3 < 3) {
                $result3 = pg_query($link, "insert into  mz430263.performance(Pianist_ID, Composition_ID) values ('$result', '$com3')");
    
                if (!$result3) {
    ?>
                    <h1>Error:</h1>
                    <center>
                        
                        <?php
                        echo pg_last_error($link) . "<br>";
                        ?>
                        <p></p>
                        <a href="form.php" class="button">Return</a>
                    </center>
    <?php
                    exit();
                }
            }
    ?>
            <h1>Your application has been accepted!</h1>
            <center>
                
                <p></p>
                <a href="homepage.html" class="button">Homepage</a>
            </center>
    <?php
            exit();
        } else {
    ?>
            <h1>Error:</h1>
            <center>
                
                <?php
                echo pg_last_error($link) . "<br>";
                ?>
                <p></p>
                <a href="form.php" class="button">Return</a>
            </center>
    <?php
            exit();
        }
        exit();
    } else {
    ?>
        <h1>Error! Applications aren't accepted now!</h1>
        <center>
            
            <a href="participants.php" class="button">Return</a>
        </center>
    <?php
        exit();
    }
    pg_close($link);
    ?>
</body>
</html>

