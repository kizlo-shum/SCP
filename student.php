<?php
$title = "Student's profile";
include "header.php";

session_start();
$id = $_GET["id"];
$dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
$sth = $dbh->prepare("SELECT intId, varFirstName, varSurname, varAvatar, varEmail FROM user WHERE intId = :id");
$sth->execute([':id' => $id]);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['isTeacher'] AND isset($_GET["id"]) AND !empty($result)) {
    $sth = $dbh->prepare("SELECT varFileName, intStudentId FROM homework WHERE intStudentId = :id");
    $sth->execute([':id' => $id]);
    $homeworks = $sth->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: /profile.php', true, 303);
    exit;
}
?>
<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <h4><a href="/profile.php">Return</a></small></h4>

        <div class="row">
            <div class="col-md-6">
                <img width="200" src="/avatars/<?= $result["varAvatar"] ?>">
            </div>
            <div class="col-md-6">
                <?php
                print "<b>Name:</b> " . $result["varFirstName"] . " " . $result["varSurname"] . "<br />";
                print $result["varEmail"] . "<br /><br /><b>Homework:</b><br />";
                $i = 0;
                foreach ($homeworks as $homework) {
                    $i++;
                    print '<a href="homeworks/' . $homework["varFileName"] . '">';
                    print $homework["varFileName"] . "</a><br />";
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>