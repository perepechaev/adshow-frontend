<h3>Список страниц</h3>

<p>
<?php foreach ($files as $file): ?>
    <a href="/manage/page/edit.html?file=<?= htmlspecialchars($file) ?>" class="edit">&nbsp;</a>
    <a href="<?= htmlspecialchars($file)?>" /><?= htmlspecialchars($file) ?></a><br />
    <br style="clear:both" />
<?php endforeach;?>
</p>
