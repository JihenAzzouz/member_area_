<?php
if (isset($_GET["id"]) && isset($_GET["token"])) {
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM register WHERE username=? AND token_reset IS NOT NULL AND token_reset=? AND token_at > DATE_SUB(NOW(),INTERVAL 30 MINUTE) ');
    $req->execute([$_GET["id"], $_GET["token"]]);
    $user = $req->fetch();
    if ($user) {
        session_start();

        if (!empty($_POST['code']) && !empty($_POST['password']) && $_SESSION['code'] === $_POST['code']) {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $pdo->prepare('UPDATE register SET password=?,token_at=NULL ,token_reset=NULL')->execute([$password]);
            $_SESSION['flash']['success'] = "your password changed successfully";
            $_SESSION['auth'] = $user;
            debug($_SESSION);
            header("location: workspace.php");
            exit();
        }
    } else {
        session_start();
        $_SESSION["flash"]['danger'] = "not valid token";
        header("location: login.php");
        exit();
    }
} else {
    header("location: login.php");
}


require_once 'inc/header.php';
?>
    <h2>Reset Password</h2>
    <form action="" method="post">
        <div class="form-group">

            <input class="form-control" type="text" name="code" placeholder="write code here.."/>
        </div>

        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="New Password.."/>
        </div>
        <button type="submit" class="btn btn-primary">Reset Password</button>

    </form>

<?php require_once 'inc/footer.php'; ?>