<h2>Авторизация</h2>
<form method="post" action="">
    <?php if (empty($error) === false): ?>
    <div class="error">
        <?= implode("<br />", $error) ?>
    </div>
    <?php endif; ?>
    <label for="name">Имя пользователя:</label><br />
    <input type="text" id="name" name="name" value="" /><br />

    <label for="pwd">Пароль:</label><br />
    <input type="password" id="pwd" name="pwd" value="" /><br />

    <input type="submit" name="auth" value="Вход" />
    <a href="/auth/signup.html">Регистрация</a>
</form>
