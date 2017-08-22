<?$titlePage='Ищу друга: найти друзей по интересам'?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<div id="page">

    <div onClick="" id="searchs">
        Найти друга по параметрам:
    <div id="searchs-form"">
        <form action="http://naitidruzei.ru/search/search/" method="post">
            <label>Город:</label>
        <select name="city">
            <option value="0" selected="selected">Все</option>
        </select>
        <label>Пол:</label>
        <select name="sex">
            <option value="0" selected="selected">Все</option>
            <option value="1">Мальчик</option>
            <option value="2">Девочка</option>
        </select>
            <p><input type="submit" value="Искать"></p>
        </form>
        </div>
    </div>

    <div id="content">
<?php foreach ($items as $article):?>
<div class="post">
    <h2 class="title"><a href="http://naitidruzei.ru/one/<?=$article->id_article;?>"><?=$article->title;?></a></h2>
    <p class="meta"><span class="date"><?=$article->date;?></span><span class="posted">Добавил: <?=$article->userName;?></span></p>
    <div style="clear: both;">&nbsp;</div>
    <div class="entry">
       <?php if(!empty($article->img_name))
       {
            echo '<img src="http://naitidruzei.ru/upload/news_img/250x250/' . $article->img_name . '" class="leftimg">';
       }
       ?>
        <?=$article->content;?>
        <p class="links"><a href="http://naitidruzei.ru/one/<?=$article->id_article;?>" class="more">Читать полностью</a>
            <a href="http://vesta-clubs.ru/one/<?=$article->id_article;?>#comments" class="comments">Оставить комментарий</a></p>
    </div>
</div>
<?php endforeach; ?>
   <?=$this->pagenav;?>
<div style="clear: both;">&nbsp;</div>
</div>
<?php
session_start();

if(!empty($_SESSION))
{
    include __DIR__ . '/../templates/templates_sidebar2.php';
}
else
{
    include __DIR__ . '/../templates/templates_sidebar.php';
}

?>

<!-- end #page -->
<?php include __DIR__ . '/../templates/templates_footer.php'; ?>