<?$title='Поделись своей радостью!'?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<h1>Редактор</h1>
<ul>
    <?php foreach ($items as $article):?>
        <li><a href="http://naitidruzei.ru/admin/update/?id=<?=$article->id_article;?>"><?=$article->title;?></a><br/>
            <?=$article->content;?></li><br/>
        =============================================
    <?php endforeach; ?>
</ul>
</body>
</html>