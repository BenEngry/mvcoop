<table>
    <tr>
        <th>
            <?=__("Id")?>
        </th>
        <th>
            <?=__("Login")?>
        </th>
        <th>
            <?=__("Describtion")?>
        </th>
        <th>
            <?=__("Sended")?>
        </th>
        <th>
            <?=__("Status")?>
        </th>
<!--        <th>-->
<!--            --><?//=__("Options")?>
<!--        </th>-->
    </tr>
    <?= $admin->getAllPromotions(isset($_GET["p"]) ? $_GET["p"] : 1); ?>
</table>
<div class="pages">
    <?=$admin->getNumPromotionsPages();?>
</div>