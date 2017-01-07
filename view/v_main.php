<?php
header('Content-type: text/html; charset=utf-8');
/*
Основной шаблон
============================
$title - заголовок
$content - содержание
*/?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Главная</a>
                </li>
                <li>
                    <a href="editor.php">Консоль редактора</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <h1><?php echo $title?></h1>
        <?php echo $content?>
    </main>

    <footer>
        <small>Все права защищены. Адрес. Телефон.<small>
    </footer>

</body>
</html>