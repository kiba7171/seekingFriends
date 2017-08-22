<?$titlePage=$items->title?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<div id="page">
    <div id="content">
    <div class="post">
        <div class="entry">
<h1><?=$items->title;?></h1>
<?=$items->content;?>
            <?php if(!empty($items->img_name))
            {
                echo '<img src="http://naitidruzei.ru/upload/news_img/' . $items->img_name . '">';
            }
            ?>
        </div>
    </div>
<?php include __DIR__ . '/../templates/templates_comments.php'; ?>
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