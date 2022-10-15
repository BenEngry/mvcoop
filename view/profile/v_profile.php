            <?= $info ?>
            <div class="control">
                <button class="controButton" id="changePass">Change password</button>
                <button class="controButton" id="changeEmail">Change email</button>
                <?php if($_SESSION["user_data"]["role"] == 0): ?>
                <button class="controButton" id="promotion">Get Promotion</button>
                <?php endif; ?>
            </div>
            <table class="users">
            <?= $table ?>
            </table>
            <div class="pages">
            <?= $pagination ?>
            </div>
        </main>
    </div>
</div>