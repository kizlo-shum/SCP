<?php
$title = "Your profile";
include "header.php";

session_start();
if (isset($_SESSION['userId'])) {
    $info = array();
    $isTeacher = 0;
    $userId = $_SESSION['userId'];
    $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');

    $sth = $dbh->prepare("SELECT isTeacher, varFirstName, varSurname, varEmail, varAvatar FROM user WHERE user.intId = :userId");
    $sth->execute([':userId' => $userId]);
    $user = $sth->fetch(PDO::FETCH_ASSOC);

    if (!$user["isTeacher"]) {
        $sth = $dbh->prepare("SELECT varFileName, intMark FROM homework WHERE homework.intStudentId = :userId");
        $sth->execute([':userId' => $userId]);
        $homeworks = $sth->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sth = $dbh->prepare("SELECT varFirstName, varSurname, intId FROM user WHERE isTeacher = :isTeacher");
        $sth->execute([':isTeacher' => $isTeacher]);
        $students = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sth = $dbh->prepare("SELECT varFileName, intStudentId FROM homework");
        $sth->execute();
        $homeworks = $sth->fetchAll(PDO::FETCH_ASSOC);
    }


} else {
    header('Location: /login.php', true, 303);
    exit;
}
?>

<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <h4><a href="/logout.php">Log out</a></h4>
        <div class="row">
            <div class="col-md-6">
                <img width="200" src="/avatars/<?= $user["varAvatar"] ?>">
            </div>
            <div class="col-md-6">
                <?= $user["varFirstName"] . " " . $user["varSurname"] ?><br/>
                <?= $user["varEmail"] ?><br/>
            </div>
        </div>
        <br/>
        <?php
        if (!$user["isTeacher"]) {
            $i = 0;
            if (!empty($homeworks)) {
                echo '<table class="table table-striped"><tr><th>Number</th><th>Link</th></tr>';
                foreach ($homeworks as $homework) {
                    $i++;
                    print "<tr><td>" . "Homework " . $i . "</td><td>";
                    print $homework["varFileName"];
                    print " " . '<a href="homeworks/' . $homework["varFileName"] . '">';
                    print '<span class="glyphicon glyphicon-save">' . "</a>";
                }
                print "</td></tr></table>";
            }
        } else {
            $j = 0;
            echo '<table class="table table-striped"><tr><th>Number</th><th>Name</th><th>Homework</th></tr>';
            foreach ($students as $student) {
                $j++;
                print "<tr><td>" . $j . "</td><td>";
                print '<a href="/student.php' . "?id=" . $student["intId"] . '">';
                print $student["varFirstName"] . " " . $student["varSurname"] . "</a></td>";
                print "<td>";
                $k = 0;
                foreach ($homeworks as $homework) {

                    if ($student["intId"] == $homework["intStudentId"]) {
                        $k++;
                    }

                }
                print '<span class="badge">' . $k . "</span>";
                print "</td></tr>";
            }
            print "</tr></table>";
        }
        ?>
    </div>
    <div class="col-md-4"></div>
</div>
</div>
</body>
</html>