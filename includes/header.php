<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Simple Forum</title>
    <link rel="stylesheet" href="/forum/css/style.css">
</head>
<body>
    <header>
        <h1>Simple Forum</h1>
        <nav>
            <ul>
                <li><a href="/forum/index.php">Home</a></li>
                <li><a href="/forum/forum.php">Forum</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="/forum/user_profile.php">Profile</a></li>
                    <li><a href="/forum/logout.php">Logout</a></li>
                    <?php if (is_admin()): ?>
                        <li><a href="/forum/admin.php">Admin</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li><a href="/forum/login.php">Login</a></li>
                    <li><a href="/forum/register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
