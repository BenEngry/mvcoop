<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/main.css">
</head>
<body>
<header class="site-header">
    <div class="container flexh__leb">
        <div class="logo">
            <div class="logo__title h3"><?= __('Lesson site') ?></div>
            <div class="logo__subtitle h6"><?= __('Про MVC') ?></div>
        </div>
        <div class="log">
            <?php 
            $role;
            if (isset($_SESSION['user_data']) and $_SESSION['user_data']['role'] == 1) {
                $role = "Admin";
            } elseif (isset($_SESSION['user_data']) and $_SESSION['user_data']['role'] == 2) {
                $role = "Manager";
            } else {
                $role = "User";
            }
            ?>

            <?php if(isset($_SESSION["is_user_logined"]) and $_SESSION["is_user_logined"]): ?>
            <a href="/profile" class="logbtn"><?= __($role) ?> : <?= $_SESSION['user_data']["name"]?></a>
            <a href="/logout" class="logbtn"><?= __('Log Out') ?></a>
            <?php else: ?>
            <a href="/register" class="logbtn" id="register"><?= __('Register') ?></a>
            <a href="/login" class="logbtn" id="login"><?= __('Log in') ?></a>
            <?php endif; ?>
        </div>
    </div>
</header>