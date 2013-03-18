<h3>Регистрация</h3>
<form method="post" id="signup">
<?php if (empty($error) === false): ?>
<div class="error">
    <?= implode("<br />", $error) ?>
</div>
<?php endif; ?>
<table>
    <tr><td><label for="name">Имя</label></td><td><input type="text" name="name" id="name" value="" /></td></tr>
    <tr><td><label for="phone">Телефон</label></td><td><input type="text" name="phone" id="phone" value="" /></td></tr>
    <tr><td><label for="phone">Email</label></td><td><input type="text" name="email" id="email" value="" /></td></tr>
    <tr><td><label for="password">Пароль</label></td><td><input type="password" name="password" id="password" value="" /></td></tr>
    <tr><td colspan="2" style="text-align: right"><input type="submit" value="Регистрация" name="signup" /></td></tr>
</table>
</form>
