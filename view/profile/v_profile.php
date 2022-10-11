
        <div class="infoUser" data-id="<?= $_SESSION['user_data']["id"] ?>">
            <p id="login" data-login="<?= $_SESSION['user_data']["name"] ?>">
                <?=__("Name")?> : <?= $_SESSION['user_data']["name"] ?>
            </p>
            <p><?=__("Email")?> : <?= $_SESSION['user_data']["email"] ?></p>
            <p>
                <?=__("Role")?> :

                <?php if($_SESSION['user_data']["role"] == 1): ?>
                    Admin
                <?php elseif($_SESSION['user_data']["role"] == 2): ?>
                    Manager
                <?php else: ?>
                    User
                <?php endif; ?>
            </p>
        </div>
        <div class="control">
            <button class="controButton" id="changePass">Change password</button>
            <button class="controButton" id="changeEmail">Change email</button>

            <?php if($_SESSION["user_data"]["role"] == 0): ?>
            <button class="controButton" id="promotion">Get Promotion</button>
            <?php endif; ?>
        </div>
        <div class="forms"></div>
        <?php if(isset($_SESSION["user_data"]) and $_SESSION["user_data"]["role"] > 0): ?>
        <table class="users">
            <tr>
                <th>Login</th>
                <th>Email</th>
                <th>Role</th>
                <th>Promotion</th>
                <th>Describtion</th>
                <th>Delete</th>
            </tr>
            <?= $admin->getPageUsers(isset($_GET["p"]) ? $_GET["p"] : 1)?>
        </table>
        <div class="pages">
            <?= $admin->pagination($admin->getNumPages("users"), "profile") ?>
        </div>
        <?php endif; ?>
        </main>
    </div>
</div>