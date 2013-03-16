<h4>Оформление заказа</h4>

<form method="post" action="/?action=order/create">
<table class="order">
<tr><td>Регион для размещения ролика</td><td>
<select name="region"><option>САРАТОВ</option><option>САРАТОВ И ОБЛАСТЬ</option></select></td></tr>

<tr><td>Сеть магазинов</td><td>
<select name="shop"><option>ГРОЗДЬ</option><option>ПЯТЕРОЧКА</option><option>МАГНИТ</option></select></td></tr>

<tr><td>Адрес</td><td>
<select name="shop"><option>не доступно</option></select></td></tr>

<tr><td>Файл рекламного ролика для отправки</td><td>
<input type="file" name="banner" /></td></tr>

<tr><td>Комментарий</td><td>
<textarea name="comment"></textarea></td></tr>

<tr><td></td><td>
<input type="submit" name="order" value="Оформить" /></td></tr>

</table>
</form>
