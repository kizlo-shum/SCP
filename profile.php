<?php
$title="Profile";
include "header.php";


session_start();
if (isset($_SESSION['userId'])) {
    $info = array();
    $userId = $_SESSION['userId'];
    $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
    $sth = $dbh->prepare("SELECT isTeacher, varFirstName, varSurname, varEmail, varAvatar FROM user WHERE user.intId = :userId");
    $sth->execute([':userId' => $userId]);
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    $sth = $dbh->prepare("SELECT varFileName, intMark FROM homework WHERE homework.intStudentId = :userId");
    $sth->execute([':userId' => $userId]);
    $homeworks = $sth->fetchAll(PDO::FETCH_ASSOC);

} else {
    header('Location: /login.php', true, 303);
    exit;
}
?>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" align="center">
            <img src="img/logo.png" alt="Логотип Миритек" title="Логотип Миритек"
                 height="200">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4" align=right>
            <img width="200" src="/avatars/<?= $user["varAvatar"] ?>">
        </div>
        <div class="col-md-4">
            <p>
                <b>First name:</b> <?= $user["varFirstName"] ?><br/>
                <b>Second name:</b> <?= $user["varSurname"] ?><br/>
                <b>E-mail:</b> <?= $user["varEmail"] ?><br/>

                <?php
                if ($user["isTeacher"] != 1) {

                    print '<table class="table table-striped">';
                    print '<tr><th>Number</th><th>Link</th><th>Mark</th></tr>';
                   /* for ($i = 0; $i < count($info); $i++) {
                        print "<tr><td>";
                        print "Homework " . ($i + 1) . ":";
                        print "</td><td>";
                        print '<a href="/homework/' . $info[$i]["varFileName"] . '">';
                        print $info[$i]["varFileName"];
                        print "</a>";
                        print "</td><td>";
                        print $info[$i]["intMark"];
                        print "</td></tr>";
                    }*/
                    $i=0;
                    foreach($homeworks as $homework) {
                        $i++;
                        print $homework["varFileName"] . $i . "<br />";
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