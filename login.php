<?php
session_start();
if (isset($_POST['login'])) {
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'swat123') {
        $_SESSION['user'] = 'admin';
        header("Location: index.php");
    } else {
        $error = "Invalid Credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Swat Garden</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #2c3e50; }
        form { background: white; padding: 30px; border-radius: 8px; width: 300px; text-align: center;}
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing:border-box;}
        button { background: #27ae60; color: white; border: none; padding: 10px; width: 100%; cursor: pointer;}
    </style>
</head>
<body>
    <form method="POST">
        <h2>Swat Garden Login</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>