
<?= $auth->testXML() ?>
<select>
<!--  TODO CREATE OPPORTUNIRT FORM AND ADD XML  -->
    <option>op1</option>
    <option>op2</option>
    <option>op3</option>
</select>
<table class="users oppor">
    <tr>
        <th>id</th>
        <th>login</th>
        <th>email</th>
        <th>role</th>
        <th>Del User</th>
        <th>Promote User</th>
        <th>Decline User</th>
        <th>Pass to log data</th>
        <th>Del users messages</th>
        <th>Reduction users messages</th>
        <th>Del other admins</th>
        <th>Del other managers</th>
        <th>Add comments</th>
        <th>Login</th>
        <th>Select</th>
    </tr>
    <?= $admin->getPageOpportunity(isset($_GET["p"]) ? $_GET["p"] : 1) ?>
</table>
<div class="pages">
    <?= $admin->pagination($admin->getNumPages("users"), "opportunity") ?>
</div>