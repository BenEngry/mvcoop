<!--        TODO Кароч, перероби цю хуйню повнюстю, без логіки пхп-->
        <?= $info ?>
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
            <?= $table ?>
        </table>
        <div class="pages">
            <?= $pagination ?>
        </div>
        <?php endif; ?>
        </main>
    </div>
</div>