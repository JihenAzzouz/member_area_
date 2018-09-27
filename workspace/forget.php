<?php
require_once 'inc/functions.php';
if(!empty($_POST) && !empty($_POST['email'])){
    require_once 'inc/db.php';
    $email= $_POST['email'];
    $req = $pdo->prepare("SELECT * FROM register WHERE (email = '$email') AND confirmed_at IS NOT NULL");
    $req->execute([':email' => $email]);
    $user = $req->fetch();
    //print_r($user);

    if($user){
        session_start();
        $reset_token=str_random(60);
        $pdo->prepare("UPDATE register SET token_reset=?,token_at=NOW() WHERE username=?")->execute([$reset_token,$user[0]]);

        $_SESSION['auth'] = $user;
        require_once 'reset_mail.php';

        $_SESSION['code']=$code;

        $_SESSION['flash']['success'] = 'follow instructions sent by Email';
        header('Location: login.php');
        debug($_SESSION);
        // exit();

    }else{

        $_SESSION['flash']['danger'] = 'account not found';

    }
}
?>
<?php require 'inc/header.php'; ?>
<h1>Password forgotten</h1>
<form action="" method="post">
    <div class="form-group">
        <label>Email : </label>
        <input type="email" name="email" class="form-control">
    </div>

    <input type="submit" value="Connexion" class="btn btn-primary" >
</form>


<?php 'inc/footer.php' ?>
