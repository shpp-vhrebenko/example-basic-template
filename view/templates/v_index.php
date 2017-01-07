<?php/*
Шаблон главной страницы
============================
$nav - постраничная навигация
$articles - статьи в виде превью
id_article - идентифицатор
title - заголовок
content - текст
date_time - дата загрузки статьи
*/?>
<?php echo $nav?>
<section>
    <div class="article">
        <?php foreach ($articles as $article): ?>
        <a href="article.php?id=<?php echo $article['id_article']?>">
            <article>
                <h3><?php echo $article['title']?></h3>
                <p>
                    <?php echo $article['content']?>...
                </p>
                <small>Дата добавления: <?php echo $article['date_time']?></small>
            </article>
            </a>
        <?php endforeach; ?>
    </div>
</section>





