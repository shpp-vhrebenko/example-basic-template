<?php
require_once 'functions/lib.php';       // подключение общей библиотеки функций
require_once 'model/m_articles.php';    // Подключение библиотеки функций для работы с статьями
startup();

// Статья
$articles = articles_getOne($_GET['id']);

// Заголовок
$title = $articles['0']['title'];

// Внутренний шаблон.
$content = view_include('view/templates/v_article.php', ['articles' => $articles]);

// Внешний шаблон.
$page = view_include('view/v_main.php', ['title' => $title, 'content' => $content]);

// Вывод.
echo $page;