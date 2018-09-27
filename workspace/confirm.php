<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require_once 'inc/db.php';
$req = $pdo->prepare("SELECT * FROM register WHERE username = '$user_id'");
$req->execute(array($user_id));
$user = $req->fetch();
session_start();
if ($user && $user[4] == $token) {
    $pdo->prepare('UPDATE register SET confirmation_token = NULL, confirmed_at = NOW() WHERE username = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = "Your account is now valid";
    $_SESSION['auth'] = $user;

    header('Location: workspace.php');

} else {
    $_SESSION['flash']['danger'] = "Token no valid";

    header('Location: login.php');
}
