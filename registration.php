<?php
$title="Registration";
include "header.php";
$text = "";

if (!empty($_POST)) {
    $firstName = strip_tags($_POST['firstName']);
    $secondName = strip_tags($_POST['secondName']);
    $email = strip_tags($_POST['email']);
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $avatarName = $_FILES['inputAvatar']['name'];

    if ($password1 != $password2) {
        $text = '<p class="text-danger">Passwords doesn\'t match.</p>';
    } else if (strlen($password1) < 8) {
        $text = '<p class="text-danger">The password is too short.</p>';
    } else if (!preg_match("#[0-9]+#", $password1)) {
        $text = '<p class="text-danger">Password must include at least one number!</p>';
    } else if (!preg_match("#[a-zA-Z]+#", $password1)) {
        $text = '<p class="text-danger">Password must include at least one letter!</p>';
    } else if ($firstName == '' or $secondName == '' or $email == '') {
        $text = '<p class="text-danger">All fields are required.</p>';
    } else if ($avatarName == '') {
        $text = '<p class="text-danger">Please choose avatar.</p>';
    } else {
        session_start();
        $ext = pathinfo($_FILES['inputAvatar']['name'], PATHINFO_EXTENSION);
        $avatarName = md5(uniqid($_FILES["inputAvatar"]["name"], true)) . "." . $ext;
        $moveResult = move_uploaded_file($_FILES['inputAvatar']['tmp_name'], 'avatars/' . $avatarName);
        $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
        $dbh->query("SET NAMES 'utf8';");
        $sql = "INSERT INTO registration.user(varFirstName, varSurname, varEmail, varAvatar, varPasswordHash)
                            VALUES(:firstName, :secondName, :email, :avatar, :md5p)";
        $sth = $dbh->prepare($sql);
        $sth->execute([
            ':firstName' => $firstName,
            ':secondName' => $secondName,
            ':email' => $email,
            ':avatar' => $avatarName,
            ':md5p' => md5($password1)
        ]);
        $_SESSION["userId"] = $dbh->lastInsertId();
        header('Location: /profile.php', true, 303);
        exit;
    }
}
?>

</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12" align="center">
            <img src="img/logo.png" alt="Логотип Миритек" title="Логотип Миритек"
                 height="200">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="centered-text">
                <h3>Registration form<br/>
                    <small>Already have an account? Please <a href="/login.php">login.</a></small>
                </h3>
                <?PHP if ($text != "") {
                    print '<div class="alert alert-danger" role="alert">';
                    print $text;
                    print '</div>';
                }?>
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
                    <input type="file" accept="image/jpeg,image/png" name="inputAvatar" id="inputAvatar"
                           value="<?php if (isset($avatarName)) {
                               print("$avatarName");
                           } ?>">
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
                <div class="form-group">
                    <button type="submit" class="btn btn-default pull-right" id="submitLogin"
                            name="submitLogin">Sign up
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
</body>
</html>