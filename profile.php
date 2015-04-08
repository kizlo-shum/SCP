<?php
$title = "Profile";
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
                    $i = 0;
                    if (!empty($homeworks)) {
                        echo '<table class="table table-striped">';
                        echo '<tr><th>Number</th><th>Link</th><th>Mark</th></tr>';
                        foreach ($homeworks as $homework) {
                            $i++;
                            print "<tr><td>" . "Homework " . $i . "</td>";
                            print "<td>" . '<a href="homeworks/' . $homework["varFileName"] . '">';
                            print $homework["varFileName"] . "</a>" . "</td><td>" . $homework["intMark"];
                        }
                    }
                }
                ?>
                </td></tr>

                </table>
                <a href="/logout.php">Log out</a>
            </p>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>