<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <title>Registration form</title>

    <?php
    $text = ' <p class="text">Please fill the registration form.</p>';
    if (!empty($_POST)) {

        $firstName = $_POST['firstName'];
        $secondName = $_POST['secondName'];
        $email = $_POST['email'];
        $avatarName = $_FILES['inputAvatar']['name'];
        $moveResult = move_uploaded_file($_FILES['inputAvatar']['tmp_name'], 'avatars/' . $avatarName);
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if ($password1 != $password2) {
            $text = '<p class="text-danger">Passwords doesn\'t match.</p>';
        } else if ($firstName == '' or $secondName == '' or $email == '') {
            $text = '<p class="text-danger">All fields are required.</p>';
        } else if ($avatarName == '') {
            $text = '<p class="text-danger">Please choose avatar.</p>';
        } else {
            session_start();

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
            $_SESSION["userId"] = $db->lastInsertId();
            header('Location: /success.php', true, 303);
            exit;
        }
    }
    ?>

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
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="centered-text">
                <h1>Registration form</h1>
                <?php print("$text"); ?>
            </div>
            <form name="loginForm" enctype="multipart/form-data" method="POST" action="registration.php">

                <div class="form-group">

                    <label for="firstName">First name</label>
                    <input type="text" class="form-control" placeholder="Enter your first name" id="firstName"
                           name="firstName" autocomplete="off" value="<?php if (isset($firstName)) {
                        print("$firstName");
                    } ?>">
                </div>
                <div class="form-group">

                    <label for="secondName">Second name</label>
                    <input type="text" class="form-control" placeholder="Enter your second name" id="secondName"
                           name="secondName" autocomplete="off" value="<?php if (isset($secondName)) {
                        print("$secondName");
                    } ?>">
                </div>
                <div class="form-group">

                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" placeholder="Enter your e-mail" id="email" name="email"
                           autocomplete="off" value="<?php if (isset($email)) {
                        print("$email");
                    } ?>">
                </div>
                <div class="form-group">
                    <label for="inputAvatar">Avatar</label>
                    <input type="file" accept="image/jpeg,image/png" name="inputAvatar" id="inputAvatar">
                </div>
                <div class="form-group">
                    <label for="password1">Password</label>
                    <input type="password" class="form-control" placeholder="Choose password" id="password1"
                           name="password1">
                </div>
                <div class="form-group">
                    <label for="password2">Password verification</label>
                    <input type="password" class="form-control" placeholder="Re-enter password" id="password2"
                           name="password2">
                </div>

                <input type="submit" class="btn btn-default pull-right" value="Sign up" id="submitLogin"
                       name="submitLogin">

            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>