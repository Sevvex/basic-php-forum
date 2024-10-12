<?php
$page_title = "Register";
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (get_user($username)) {
        $error = "Username already exists";
    } else {
        $user = create_user($username, $password, $email);
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
    }
}
?>

<h2>Register</h2>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<form action="register.php" method="post">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <input type="submit" value="Register">
    </div>
</form>

<?php include 'includes/footer.php'; ?>
