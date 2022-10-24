<?php if ($successText): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully added!') ?>
    </div>
<?php endif; ?>
<ul>
    <?= $messages ?>
    <div class="pages">
        <?= $pagination ?>
    </div>
</ul>
