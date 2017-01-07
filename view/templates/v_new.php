<?php/*
Шаблон создания новой статьи
============================
$notice - уведомление
*/?>
<section>
    <b class="red"><?=$notice?></b>
    <form method="post" enctype="multipart/form-data" autocomplete="off">
        <label>
            Заголовок:
            <br>
            <input type="text" name="title" value="<?=$title_form?>">
        </label>
        <br>
        <br>
        <label>
            Содержание:
            <br>
            <textarea name="content"><?=$content_form?></textarea>
        </label>
        <br>
        <input type="submit" value="Добавить">
    </form>
</section>


