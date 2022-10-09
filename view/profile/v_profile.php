
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
            <?php foreach($admin->getPageUsers(isset($_GET["p"]) ? $_GET["p"] : 1) as $row => $data): ?>
            <?php
            $roleclass = "user";

            if($data[3] == 1) {
                $roleclass = "admin";
            } elseif ($data[3] == 2) {
                $roleclass = "manager";
            } else {
                $roleclass = "user";
            }
            ?>

            <tr>
                <td><?=__("Name")?> : <pre class="<?= $roleclass ?>"><?= $data[1] ?></pre></td>
                <td><?=__("Email")?> : <?= $data[2] ?></td>
                <td><?=__("Role")?> : <?= $data[3] ?></td>
                <td>
                    <button data-id=<?=$data[0]?> data-type="up" class="up btn" value="up <?= $row?> "> up </button>
                    <button data-id=<?=$data[0]?>  data-type="down" class="down btn" value="down <?= $row?>"> down </button>
                </td>
                <td class="decs">
                    <?php if($data[6] == "consider"): ?>
                        <div><?= $data[5] ?></div>
                        <div><?= $data[4] ?></div>
                        <div>
                            <button data-id=<?=$data[0]?> data-type="up" class="up btn" value="up <?= $row?> "> Promote </button>
                            <button data-id=<?=$data[0]?> data-type="declain" class="disagree btn"> Declain </button>
                        </div>
                    <?php else: ?>
                        <p>none</p>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($_SESSION['user_data']["name"] !== $data[1]): ?>
                    <button data-id=<?=$data[0]?> data-type="del" class="del btn"> X </button>
                    <?php else: ?>
                    <p>it is you</p>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="pages">
            <?php foreach(range(1,$admin->getNumPages()) as $number): ?>
                <a class="pageButton" href="/profile?p=<?= $number ?>"><?=$number?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?= $admin->testPDO(); ?>
        </main>
    </div>
</div>