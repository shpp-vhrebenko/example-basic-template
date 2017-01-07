<?php/*
Шаблон статьи
============================
$articles - статья
content - текст
date_time - дата загрузки статьи
*/?>
<section>
    <? foreach ($articles as $article): ?>
        <p>
            <?=nl2br($article['content'])?>
        </p>
        <small>Дата добавления: <?=$article['date_time']?></small>
    <? endforeach; ?>
</section>