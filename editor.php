<?php
require_once 'functions/lib.php';       // подключение общей библиотеки функций
require_once 'model/m_articles.php';    // Подключение библиотеки функций для работы с статьями
startup();

// Удаление статьи
if(isset($_GET['delete'])) {
    if(articles_delete($_GET['delete'])) {
        $_SESSION['notice'] = 'Статья успешно удаленна';
        redirect('editor.php');
    }
    else {
        $_SESSION['notice'] = 'Ошибка';
    }
}

// Выборка всех статей в виде списка
$articles = articles_getList();

// Заголовок
$title = 'Консоль редактора';

// Уведомление
$notice = flashMessage('notice');

// Внутренний шаблон.
$content = view_include('view/templates/v_editor.php', ['articles' => $articles, 'notice' => $notice]);

// Внешний шаблон.
$page = view_include('view/v_main.php', ['title' => $title, 'content' => $content]);

// Вывод.
echo $page;