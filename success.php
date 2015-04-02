<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <title>Registration form</title>

    <?php
    session_start();
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
        $sth = $dbh->prepare("SELECT firstName, secondName, email, avatar FROM users where id = $userId");
        $sth->execute();
        $result = $sth->fetchAll();
    }
    ?>

</head>

<body>



<div class="container-fluid">
    <div class="row">
        <p align="center" class="text-center">
            <a href="/registration.php"><img src="img/miritec_logo.png" alt="Логотип Миритек" title="Логотип Миритек"
                                             height="200"></a>
        </p><br/>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php
            print "<p align=right>";
            print '<img width="200" src="/avatars/'.$result[0][3].'" >';
            print "</p>";
            ?>
        </div>
        <div class="col-md-4">
            <?php
                print "<p>";
                print "First name: ".$result[0][0]."<br />";
                print "Second name: ".$result[0][1]."<br />";
                print "email: ".$result[0][2]."<br />";
                print "</p>";
             ?>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>