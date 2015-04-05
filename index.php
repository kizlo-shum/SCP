<?php
session_start();
if (isset($_SESSION['userId'])) {
    header('Location: /profile.php', true, 303);
} else {
    header('Location: /login.php', true, 303);
}