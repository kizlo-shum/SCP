<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <title>Registration form</title>

    <?php
    session_start();
    $text = "";
    if (!empty($_POST)) {
        $email = $_POST['email'];
        $passwordHash = md5($_POST['password']);
        $dbh = new PDO('mysql:host=localhost; dbname=registration; charset=UTF8', 'root', '6710omne8864');
        $sth = $dbh->prepare("SELECT id, passwordHash FROM users where email = :email");
        $sth->execute([':email' => $email]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $_SESSION["userId"] = $result["id"];
        if ($result) {
            if ($result["passwordHash"] === $passwordHash) {
                header('Location: /success.php', true, 303);
                exit;
            } else {
                $text = "Pair login/password does not exist";
            }

        } else {
            $text = "Pair login/password does not exist";
        }
    }

    ?>

</head>

<body>

<div class="container-fluid">
    <div class="row">
        <p align="center" class="text-center">
            <img src="img/miritec_logo.png" alt="Логотип Миритек" title="Логотип Миритек" height="200">
        </p>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="centered-text">
                <h3>Please login or <a href="/registration.php">create</a> new account</h3>
                <?PHP if ($text != "") {
                    print '<div class="alert alert-danger" role="alert">';
                    print $text;
                    print '</div>';
                }?>
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