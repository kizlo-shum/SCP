<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <title>Profile</title>

    <?php
    session_start();
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
        $sth = $dbh->prepare("SELECT isTeacher, firstName, secondName, email, avatar FROM users WHERE users.id = :userId");
        $sth->execute([':userId' => $userId]);
        $user = $sth->fetch();
    } else {
        header('Location: /login.php', true, 303);
        exit;
    }
    ?>

</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" align="center">
            <img src="img/miritec_logo.png" alt="Логотип Миритек" title="Логотип Миритек"
                 height="200">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <p align=right>
                <img width="200" src="/avatars/<?= $user["avatar"] ?>">
            </p>
        </div>
        <div class="col-md-4">
            <p>
                <b>First name:</b> <?= $user["firstName"] ?><br/>
                <b>Second name:</b> <?= $user["secondName"] ?><br/>
                <b>E-mail:</b> <?= $user["email"] ?><br/>
                <a href="/logout.php">Log out</a>
            </p>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>