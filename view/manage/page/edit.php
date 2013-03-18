<h3>Редактирование страницы</h3>
<p>
<a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></a>
</p>

<form method="post">
    <textarea name="content" style="width:100%;height:400px"><?= htmlspecialchars($content) ?></textarea>
    <input type="submit" name="preview" value="Предпросмотр" />
    <input type="submit" name="save-page" value="Сохранить" />
</form>

<div>
<h4 style="background: #888; color: white;">Предпросмотр</h4>
<?= $content ?>
</div>
