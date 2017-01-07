<?php
require_once 'functions/lib.php';       // подключение общей библиотеки функций
require_once 'model/m_articles.php';    // Подключение библиотеки функций для работы с статьями
startup();


// НАДА ДОДЕЛАТЬ

// Выборка всех статей в виде превью
$articles = articles_getPreview(30, $_GET['page'], 5);

// Кол-во записей в таблице
$count = articles_count()['0']['COUNT(*)'];

$num = $count / 5;

// Заголовок
$title = 'Главная';

// Внутренний шаблон.
$nav = view_include('view/templates/v_page_nav.php', ['num' => $num]);

// Внутренний шаблон.
$content = view_include('view/templates/v_index.php', ['articles' => $articles, 'nav' => $nav]);

// Внешний шаблон.
$page = view_include('view/v_main.php', ['title' => $title, 'content' => $content]);

// Вывод.
echo $page;


