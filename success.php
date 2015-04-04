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
        $sth = $dbh->prepare("SELECT firstName, secondName, email, avatar FROM users where id = :userId");
        $sth->execute([':userId' => $userId]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
    } else {
        header('Location: /login.php', true, 303);
        exit;
    }
    ?>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <p align="center" class="text-center">
            <a href="/login.php"><img src="img/miritec_logo.png" alt="Логотип Миритек" title="Логотип Миритек"
                                             height="200"></a>
        </p><br/>
    </div>
    <div class="row">
        <div class="col-md-4">
            <p align=right>
                <img width="200" src="/avatars/<?= $result["avatar"] ?>">
            </p>
        </div>
        <div class="col-md-4">
            <p>
                <b>First name:</b> <?= $result["firstName"] ?><br/>
                <b>Second name:</b> <?= $result["secondName"] ?><br/>
                <b>E-mail:</b> <?= $result["email"] ?><br/>
            </p>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>