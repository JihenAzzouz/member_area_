<?php

require_once 'inc/functions.php';
require_once 'inc/db.php';
reconnect();
if (isset($_SESSION['auth'])){
    header("location workspace.php");
    exit();
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['pwd'])) {

    $username = $_POST['username'];
    $req = $pdo->prepare("SELECT * FROM register WHERE (username = '$username' OR email = '$username') AND confirmed_at IS NOT NULL");
    $req->execute([':username' => $username]);
    $user = $req->fetch();
    


    if (password_verify($_POST['pwd'], $user[2])) {

        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = 'You are now connected';

        if ($_POST['remember']) {
            $remember_token = str_random(255);
            $pdo->prepare('UPDATE  register SET remember_token=? WHERE username=?')->execute([$remember_token, $user[0]]);
            setcookie('remember', $user[0] . '==' . $remember_token/*,md5($user[0]."fool")*/, time() + 60 * 60 * 24 * 7);

        }

        header('Location: workspace.php');
        exit();

    } else {

        $_SESSION['flash']['danger'] = 'username or password is incorrect';

    }
}
?>
<?php require 'inc/header.php'; ?>
<div class="col-xs-6"><br><br><br><br>
    <img src="https://freedesignfile.com/upload/2017/01/Girl-watching-movies-on-a-computer-HD-picture.jpg" class="img-responsive"
         alt="" width="700" height="100%">
</div>
<div class="col-xs-6">
<h1>Log In </h1>
<form action="" method="post">
    <div class="form-group">
        <label>Username : </label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label>Password : <a href="forget.php">(I forgot my password)</a></label>
        <input type="password" name="pwd" class="form-control">

    </div>
    <div class="form-group">
        <input type="checkbox" name="remember" value="1">Remember Me
    </div>
    <input type="submit" value="Connexion" class="btn btn-primary">
</form>
<div>
<br><br>
<p>Not yet a member?<a href="register.php"> Sign Up now</a></p>
</div>
</div>
<?php 'inc/footer.php' ?>
