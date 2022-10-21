<?= time() ?>
<?php if ($successText): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully added!') ?>
    </div>
<?php endif; ?>
<ul>
    <?php foreach ($messages as $message): ?>
    <li id="lid-<?= $message['id'] ?>">
        <label><strong><?= __('Message id') ?>:</strong></label><em id="lid-<?= $message['id'] ?>-id"><?= $message['id'] ?></em><br>
        <label><strong><?= __('User Name') ?>:</strong></label><em id="lid-<?= $message['id'] ?>-name"><?= $message['name'] ?></em><br>
        <label><strong><?= __('Title') ?>:</strong></label><em id="lid-<?= $message['id'] ?>-title"><?= $message['title'] ?></em><br>
        <label><strong><?= __('Message') ?>:</strong></label><em id="lid-<?= $message['id'] ?>-message"><?= $message['message'] ?></em><br>
        <label><strong><?= __('Created At') ?>:</strong></label><em id="lid-<?= $message['id'] ?>-time"><?= $message['created_at'] ?></em><br>    
        <?php if (isset($_SESSION['user_data']) and $_SESSION['user_data']['role'] == "1"):?>
        <input type="submit" id="admin" value=<?= $message['id'] ?>>Edit A</input>
        <?php elseif (isset($_SESSION['user_data']) and $_SESSION['user_data']['role'] == "2"):?>
        <input type="submit" id="manager" value=<?= $message['id'] ?>>Edit M</input>
        <?php endif ?>
        <hr>
        <?php endforeach; ?>
    </li>
</ul>
