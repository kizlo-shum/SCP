<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <title>Registration form</title>


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
            print "<p align=right> <img class=img-responsive src = avatars/" . $_FILES['inputAvatar']['name'] . " width=200></img></p>";
            ?>
        </div>
        <div class="col-md-4">

            <?php
            if (!empty($_POST)) {
                $firstName = $_POST['firstName'];
                $secondName = $_POST['secondName'];
                $email = $_POST['email'];
                $avatarName = $_FILES['inputAvatar']['name'];
                $moveResult = move_uploaded_file($_FILES['inputAvatar']['tmp_name'], 'avatars/' . $avatarName);
                $password1 = $_POST['password1'];
                $password2 = $_POST['password2'];
                print "<b>Congratulations! You have successfully registered!</b>b>" . "<br />";
                print "First name: " . $firstName . "<br />";
                print "Second name: " . $secondName . "<br />";
                print "e-mail: " . $email . "<br />";

                $db = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
                $db->query("SET NAMES 'utf8';");
                $sql = "INSERT INTO registration.users(firstName, secondName, email, avatar, passwordHash)
                    VALUES(:firstName, :secondName, :email, :avatar, :md5p)";
                $sth = $db->prepare($sql);
                $sth->execute([
                    ':firstName' => $firstName,
                    ':secondName' => $secondName,
                    ':email' => $email,
                    ':avatar' => $avatarName,
                    ':md5p' => md5($password1)
                ]);
            }

            ?>

        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>