<?php
require_once 'inc/functions.php';
logged_only();
if (!empty($_POST)) {
    if (empty($_POST['password1'])||$_POST['password1'] != $_POST['password2']) {
        $_SESSION['flash']['danger'] = 'passwords dont match';
    } else {
        $user_id = $_SESSION['auth'][0];
        $pwd = password_hash($_POST['password1'], PASSWORD_BCRYPT);
        require_once 'inc/db.php';
        $req = $pdo->prepare('UPDATE register SET password=?');
        $req->execute([$pwd]);
        $_SESSION['flash']['success'] = 'password changed successfully';
    }
}
require_once 'inc/header.php';
?>

<h3> Hello ! <?= $_SESSION['auth'][0]; ?></h3>
<div>
    <img src="cover.jpg" width="100%" height="600" />
</div>
<div class="jumbotron text-center">
    <h2>Workspace</h2>
    <p>blablabla...</p>
    <form class="form-inline">
        <div class="input-group">
            <input type="email" class="form-control" size="50" placeholder="Email Address" required>
            <div class="input-group-btn">
                <button type="button" class="btn btn-danger">Recieve NewsLetter</button>
            </div>
        </div>
    </form>
</div>
<hr>
<h2>profile</h2>
<form action="" method="post">
    
    <h4>change password</h4>
    <div class="form-group">
        <input class="form-control" type="password" name="password1" placeholder="Change your password"/>
    </div>

    <div class="form-group">
        <input class="form-control" type="password" name="password2" placeholder="Confirm password"/>
    </div>
    <button type="submit" class="btn btn-primary">Validate</button>

</form>

<?php require_once 'inc/footer.php'; ?>
