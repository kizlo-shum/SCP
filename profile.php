<?php
$title = "Profile";
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

    $sth = $dbh->prepare("SELECT varFileName, intMark FROM homework WHERE homework.intStudentId = :userId");
    $sth->execute([':userId' => $userId]);
    $homeworks = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth = $dbh->prepare("SELECT varFirstName, varSurname FROM user WHERE isTeacher = :isTeacher");
    $sth->execute([':isTeacher' => $isTeacher]);
    $students = $sth->fetchAll(PDO::FETCH_ASSOC);


} else {
    header('Location: /login.php', true, 303);
    exit;
}
?>

<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-6">
                <img width="200" src="/avatars/<?= $user["varAvatar"] ?>">
            </div>
            <div class="col-md-6">
                <?= $user["varFirstName"] . " " . $user["varSurname"] ?><br/>
                <b>E-mail:</b> <?= $user["varEmail"] ?><br/>
                <a href="/logout.php">Log out</a>
            </div>
        </div>
        <br />
        <?php
        if (!$user["isTeacher"]) {
            $i = 0;
            if (!empty($homeworks)) {
                echo '<table class="table table-striped"><tr><th>Number</th><th>Link</th><th>Mark</th></tr>';
                foreach ($homeworks as $homework) {
                    $i++;
                    print "<tr><td>" . "Homework " . $i . "</td>";
                    print "<td>" . '<a href="homeworks/' . $homework["varFileName"] . '">';
                    print $homework["varFileName"] . "</a>" . "</td><td>" . $homework["intMark"];
                }
                print "</td></tr></table>";
            }
        }
        else {
            $i = 0;
            echo '<table class="table table-striped"><tr><th>Number</th><th>Name</th></tr>';
            foreach ($students as $student) {
                $i++;
                print "<tr><td>" . $i . "</td>";
                print "<td>" . $student["varFirstName"] . " " . $student["varSurname"] . "</td></tr>";

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