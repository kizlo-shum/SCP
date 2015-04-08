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
        $info = array();
        $userId = $_SESSION['userId'];
        $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
        $sth = $dbh->prepare("SELECT isTeacher, varFirstName, varSurname, varEmail, varAvatar, varFileName, intMark FROM user LEFT JOIN homework ON user.intId = homework.intStudentId WHERE user.intId = :userId");
        $sth->execute([':userId' => $userId]);


        while (($row = $sth->fetch(PDO::FETCH_ASSOC)) !== false) {
            array_push($info, $row);
        }
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
        <div class="col-md-4" align=right>
            <img width="200" src="/avatars/<?= $info[0]["varAvatar"] ?>">
        </div>
        <div class="col-md-4">
            <p>
                <b>First name:</b> <?= $info[0]["varFirstName"] ?><br/>
                <b>Second name:</b> <?= $info[0]["varSurname"] ?><br/>
                <b>E-mail:</b> <?= $info[0]["varEmail"] ?><br/>

                <?php
                if ($info[0]["isTeacher"] != 1) {
                    print '<table class="table table-striped">';
                    print '<tr><th>Number</th><th>Link</th><th>Mark</th></tr>';
                    for ($i = 0; $i < count($info); $i++) {
                        print "<tr><td>";
                        print "Homework " . ($i + 1) . ":";
                        print "</td><td>";
                        print '<a href="/homework/' . $info[$i]["varFileName"] . '">';
                        print $info[$i]["varFileName"];
                        print "</a>";
                        print "</td><td>";
                        print $info[$i]["intMark"];
                        print "</td></tr>";
                    }
                }
                ?>
                </table>
                <a href="/logout.php">Log out</a>
            </p>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>