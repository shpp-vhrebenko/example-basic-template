<?php
require_once 'functions/lib.php';       // подключение общей библиотеки функций
require_once 'model/m_articles.php';    // Подключение библиотеки функций для работы с статьями
startup();

// Проверка отправки формы
if(!empty($_POST) && isset($_POST['title']) && isset($_POST['content'])) {
    if(articles_check($_POST['title'], $_POST['content'])) {
        articles_add($_POST['title'], $_POST['content']);
        $_SESSION{'notice'} = 'Статья успешно загружена';
        redirect('editor.php');
    } else {
        $_SESSION['title'] = $_POST['title'];
        $_SESSION['content'] = $_POST['content'];
        redirect('new.php');
    }
}

$title_form = flashMessage('title');
$content_form = flashMessage('content');

// Заголовок
$title = 'Новая статья';

// Уведомление
$notice = flashMessage('notice');

// Внутренний шаблон.
$content = view_include('view/templates/v_new.php', ['title' => $title, 'title_form' => $title_form,
                                                     'content_form' => $content_form, 'notice' => $notice]);

// Внешний шаблон.
$page = view_include('view/v_main.php', ['title' => $title, 'content' => $content,]);

// Вывод.
echo $page;