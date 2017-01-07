<?php/*
Шаблон постраничной навигации
============================
$num - определяет кол-во страниц
*/
?>

<div class="page">
    <? if($num > $i = 1): ?>
        <a href="index.php">1</a>
        <?  while($i++ < $num): ?>
            <a href="index.php?page=<?=$i?>"><?=$i?></a>
        <? endwhile; ?>
    <? endif; ?>
</div>
