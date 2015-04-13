<?php
$title = "Student's profile";
include "header.php";
session_start();
$id = $_GET["id"];
$dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
$sth = $dbh->prepare("SELECT intId, varFirstName, varSurname, varAvatar, varEmail FROM user WHERE intId = :id");
$sth->execute([':id' => $id]);
$result = $sth->fetch(PDO::FETCH_ASSOC);

if ($_SESSION['isTeacher'] AND isset($_GET["delete"])) {
    $workId = $_GET["delete"];
    $sth = $dbh->prepare("DELETE FROM homework WHERE intId = :workId");
    $sth->execute([':workId' => $workId]);
    header("Location: /student.php?id=" . $id, true, 303);
} else if ($_SESSION['isTeacher'] AND isset($_GET["id"]) AND !empty($result)) {
    $sth = $dbh->prepare("SELECT intId, varFileName, intStudentId FROM homework WHERE intStudentId = :id");
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
                print $result["varFirstName"] . " " . $result["varSurname"] . "<br />";
                print $result["varEmail"] . "<br /><br /><b>Homework:</b><br />";
                $i = 0;
                foreach ($homeworks as $homework) {
                    print $homework["varFileName"];
                    print " " . '<a href="homeworks/' . $homework["varFileName"] . '" title="Download">';
                    print '<span class="glyphicon glyphicon-download">';
                    print "</a>";
                    print " " . '<a href="?id=' . $id . '&delete=' . $homework["intId"] . '" title="Delete">';
                    print '<span class="glyphicon glyphicon-trash">';
                    print "</a><br />";
                }
                if ($_SESSION['isTeacher'] AND !empty($_POST)) {
                    $ext = pathinfo($_FILES['inputFile']['name'], PATHINFO_EXTENSION);
                    $homeworkName = "homework_" . substr(md5(uniqid($_FILES["inputFile"]["name"], true)), 0, 5);
                    $homeworkName .= "." . $ext;
                    $moveResult = move_uploaded_file($_FILES['inputFile']['tmp_name'], 'homeworks/' . $homeworkName);
                    $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
                    $dbh->query("SET NAMES 'utf8';");
                    $sql = "INSERT INTO registration.homework(intTeacherId, varFilename, intMark, intStudentId)
                            VALUES(:intTeacherId, :varFilename, :intMark, :intStudentId)";
                    $sth = $dbh->prepare($sql);
                    $sth->execute([
                        ':intTeacherId' => $_SESSION["userId"],
                        ':varFilename' => $homeworkName,
                        ':intMark' => 0,
                        ':intStudentId' => $id
                    ]);
                    header('Location: /student.php?id='.$id, true, 303);
                }
                ?>
                <br />
                <label for="uploadForm">Add homework</label>
                <form name="uploadForm" enctype="multipart/form-data" method="POST" action="student.php?id=<?=$id?>">
                    <div class="form-group">
                        <input type="file" name="inputFile" id="inputFile">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default" id="submitLogin"
                                name="uploadButton">Add homework
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>