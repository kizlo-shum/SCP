<?php
session_start();
if (isset($_SESSION['userId'])) {
    header('Location: /success.php', true, 303);
} else {
    header('Location: /login.php', true, 303);
}