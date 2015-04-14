<?php
$title = "Login";
include "header.php";
session_start();
$text = "";
if (!empty($_POST)) {
    $email = $_POST['email'];
    $passwordHash = md5($_POST['password']);
    $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
    $sth = $dbh->prepare("SELECT intId, isTeacher, varPasswordHash FROM user WHERE varEmail = :email");
    $sth->execute([':email' => $email]);
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $_SESSION["userId"] = $result["intId"];
    $_SESSION["isTeacher"] = $result["isTeacher"];
    if ($result) {
        if ($result["varPasswordHash"] === $passwordHash) {
            header('Location: /profile.php', true, 303);
            exit;
        } else {
            $text = "Pair login/password does not exist";
        }
    } else {
        $text = "Pair login/password does not exist";
    }
}

?>

<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="centered-text">
            <h4>Don't have an account yet? Please <a href="/registration.php">create</a> one.</h4>
            <?= ($text != "") ? '<div class="alert alert-danger" role="alert">' . $text . '</div>' : "" ?>
        </div>
        <form name="loginForm" method="POST" action="login.php">

            <div class="form-group">

                <label for="email">E-mail</label>
                <input type="email" class="form-control" placeholder="Enter your email" id="email"
                       name="email">
            </div>
            <div class="form-group">

                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Enter your password" id="password"
                       name="password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default pull-left" id="submitLogin"
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