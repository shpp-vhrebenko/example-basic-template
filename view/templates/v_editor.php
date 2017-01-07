<?php/*
Шаблон страницы редактора
============================
$articles - статьи в виде списка
id_article - идентифицатор
title - заголовок
date_time - дата загрузки статьи
$notice - уведомление
*/?>
<section>
    <b><a href="new.php">Новая статья</a></b>
    <ul>
    <? foreach ($articles as $article): ?>
            <li>
                <a href="edit.php?id=<?=$article['id_article']?>">
                    <?=$article['title']?>
                </a>
                <br>
                <a class="red" href="editor.php?delete=<?=$article['id_article']?>">удалить</a>
            </li>
    <? endforeach; ?>
    </ul>
    <b class="green"><?=$notice?></b>
</section>
