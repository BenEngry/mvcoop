<label for="oppor">Opportunity:</label>
<select name="oppor" id="oppor">
    <option value="delUser">Del User</option>
    <option value="promoteUser">Promote User</option>
    <option value="declineUser">Decline User</option>
    <option value="passToLogData">Pass to log data</option>
    <option value="reductionUsersMessages">Reduction users messages</option>
    <option value="delUsersMessages">Del users messages</option>
    <option value="delOtherAdmins">Del other admins</option>
    <option value="delOtherManagers">Del other managers</option>
    <option value="addComments">Add comments</option>
    <option value="loginingToPage">Login</option>
</select>
<label for="action"></label>
<select name="action" id="type">
    <option value="1">Add</option>
    <option value="0">Remove</option>
</select>
<button type="submit" class="sendd">Send</button>
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
    <?= $table ?>
</table>
<div class="pages">
    <?= $paggination ?>
</div>
