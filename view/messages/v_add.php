<form method="post">
    <div>
        <label for="messageName"><?= __('Title') ?></label>
        <input id="messageName" name="title" value="<?= $fields['title'] ?>">
    </div>
    <div>
        <label for="messageId"><?= __('Message') ?></label>
        <textarea type="text" name="message" id="messageId"><?= $fields['message'] ?></textarea>
    </div>

    <input name="submit" value="<?= __('Save') ?>" type="submit">
</form>
<div>
    <? foreach($validateErrors as $error): ?>
        <p><?=$error?></p>
    <? endforeach; ?>
</div>