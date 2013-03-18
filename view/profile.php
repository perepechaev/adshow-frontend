<h3>Личный кабинет</h3>
<?php $user = Auth::getUser(); ?>

<p>
<?= htmlspecialchars($user->name); ?>
</p>

<h4>Загрузить рекламный блок</h4>
<form action="/banner/upload.html" method="post" enctype='multipart/form-data'>
    <input type="file" name="banner" />
    <input type="submit" name="upload" value="Загрузить" />
</form>
