<?php
require_once 'functions/lib.php';       // подключение общей библиотеки функций
require_once 'model/m_articles.php';    // Подключение библиотеки функций для работы с статьями
startup();


// Редирект, если id не передан
if(empty($_GET['id'])) {
    redirect('editor.php');
}

// Выборка одной статьки, по id
$articles = articles_getOne($_GET['id']);
$id = $_GET['id'];

// Проверка отправки формы
if(!empty($_POST) && isset($_POST['title']) && isset($_POST['content'])) {
    $title_new = $_POST['title'];
    $content_new = $_POST['content'];
    if(articles_check($title_new, $content_new)) {
        articles_add($_POST['title'], $_POST['content']);
        $_SESSION{'notice'} = 'Статья успешно отредактирована';
        redirect('editor.php');
    } else {
        redirect("edit.php?id=$id");
    }
}

// Заголовок
$title = 'редактирование статьи';

// Уведомление
$notice = flashMessage('notice');

// Внутренний шаблон.
$content = view_include('view/templates/v_edit.php', ['articles' => $articles, 'notice' => $notice]);

// Внешний шаблон.
$page = view_include('view/v_main.php', ['title' => $title, 'content' => $content]);

// Вывод.
echo $page;