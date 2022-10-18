<nav class="site-nav">
    <div class="container navbar">
        <li class="nav">
        <?= $nav ?>
        </li>
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
            <h1><?=$title?></h1>
            <hr>
