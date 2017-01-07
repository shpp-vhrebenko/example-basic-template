<?php/*
Шаблон создания новой статьи
============================
$notice - уведомление
title - заголовок
content - текст
*/?>
<section>
    <b class="red"><?=$notice?></b>
    <form method="post" enctype="multipart/form-data" autocomplete="off">
        <label>
            Заголовок:
            <br>
            <input type="text" name="title" value="<?=$articles['0']['title']?>">
        </labeL>
        <br>
        <br>
        <label>
            Содержание:
            <br>
            <textarea name="content"><?=$articles['0']['content']?></textarea>
        </label>
        <br>
        <input type="submit" value="Сохранить" />
    </form>
</section>
