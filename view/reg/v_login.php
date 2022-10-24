<nav class="site-nav">
    <div class="container navbar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>"><?= __('Home')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>messages/add"><?= __('Add')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>contacts"><?= __('Contacts')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>contacts"><?= __('Not Exists')?></a>
            </li>
        </ul>
        <ul class="nav navtwo">
            <li class="nav-item">   
                <form action="" id="trans">
                    <select name="ln" id="translate">
                        <option value="en" <?php if ($_SESSION['ln'] == "en"): ?> selected <?php endif; ?> >EN</option >
                        <option value="ua" <?php if ($_SESSION['ln'] == "ua"): ?> selected <?php endif; ?> >UA</option >
                        <option value="pl" <?php if ($_SESSION['ln'] == "pl"): ?> selected <?php endif; ?> >PL</option >
                    </select>
                </form>
            </li>
        </ul>
    </div>
</nav>
<div class="site-content">
    <div class="container">
        <main>
            <h1><?=__("Login")?></h1>
            <hr>
            <div class="reg">
                <div class="validate">
                    <?php if($_SESSION["log"] = "undefinded data"):?>
                    <h2>Invalid login</h2>
                    <?php elseif($_SESSION["log"] = "lod data invalid"): ?>
                    <h2>Invalid email or password</h2>
                    <?php endif ?>                    
                </div>
                <form class="regform" method="POST">
                    <label for="name" class="name"><?=__('Name')?></label>
                    <input type="text" name="name" id="name">
                    <label for="email" class="email"><?=__('Email')?></label>
                    <input type="email" name="email" id="email">
                    <label for="password" class="password"><?=__('Password')?></label>
                    <input type="password" name="password" id="password">
                    <input  type="submit"class="submit__btn" id="sendDataBtn" placeholder=<?=__("Login")?>></input>
                </form>
            </div>