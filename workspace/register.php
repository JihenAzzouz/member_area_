<?php
require 'inc/header.php';
require 'inc/functions.php';
?>

<?php
require_once 'class/Database.php';
$db=new Database("root","","gomycode");
$req = $db->query("SELECT username FROM register")->fetchAll();

debug($req);
die();
if (!empty($_POST) && isset($_POST)) {
   // echo "hello";
    $name = test_input($_POST["name"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["pwd1"]);
    $confirm = test_input($_POST["pwd2"]);
    $errors = array();
    require('inc/db.php');
    if (empty($username) || !preg_match('/^[a-zA-Z ]+$/', $username)) {
        $errors['username'] = 'Enter a validate user name (No special chars)';
    } else {
        $req = $pdo->prepare("SELECT username FROM register WHERE  username=?");
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        debug($user);
        if ($user) {
            $errors['username'] = "username exists";
        }

    }
    if (empty($name) || !preg_match('/^[a-zA-Z ]+$/', $name)) {
        $errors['name'] = 'Enter a validate  name (No numeric chars )';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a validate email)';
    } else {
        $req = $pdo->prepare("SELECT email FROM register WHERE  email=?");
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        debug($user);
    }

    if ($user) {
        $errors['email'] = "email already used";
    }
    if (strlen($password) < 8 ) {
        $errors['password'] = 'Password must have at least 8 characters';
    }

    if (empty($password) || empty($confirm)) {
        $errors['password'] = 'Password is required';
    }
    if ($password != $confirm) {
        $errors['password'] .= 'passwords dosent match ';
    }
    if (empty($errors)) {
        require_once 'inc/db.php';
        $req = $pdo->prepare('INSERT INTO register SET username=?,name=?,password=?,email=?,confirmation_token=?');
        $password = crypt($_POST['pwd1'], '$2a$07$usesomesillystringforsalt$');
        $token = str_random(60);
        $req->execute([$username, $name, $password, $email, $token]);
        require_once 'mail.php';
        $_SESSION['flash']['success']="confirmation email sent check your inbox";
        header('location: login.php');
        exit();


    }

}

?>
    <div class="col-xs-6 "><br><br><br><br>
        <img src="https://ak9.picdn.net/shutterstock/videos/10233779/thumb/1.jpg" class="img-responsive" alt="" >
    </div>
    <div class="col-xs-6">
    <h1>Register Form</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <p> you didn't fill the inputs correctly </p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label>Username :</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group">
            <label>Name :</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Password :</label>
            <input type="password" name="pwd1" class="form-control">
        </div>
        <div class="form-group">
            <label>Password Confirmation :</label>
            <input type="password" name="pwd2" class="form-control">
        </div>

        <input type="submit" class="btn btn-primary" name="submit" value="submit">
    </form>
    </div>
<?php require 'inc/footer.php'; ?>