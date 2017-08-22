<h3>Добавить комментарий:</h3>
    <?php foreach ($comments as $comment):?>
    <div class="post">
        <div class="comment">
            <ul>
        <li><?=$comment->name;?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$comment->date;?></li><br/>
        <?=$comment->text;?><br/>
            </ul>
        </div>
    </div>
    <?php endforeach; ?>

<form method="post">
    <p><a name="comments"></a></p>
    <p class="error"><?=$error?></p>
    <p><b>Ваше имя:</b></p>
    <p><input type="text" name="name" value="<?=$name?>"></p>
    <p><b>Email:</b></p>
    <p><input type="email" name="email" value="<?=$email?>"></p>
    <p><b>Комментарий:</b></p>
    <p><textarea name="text" cols="70" rows="15"><?=$text?></textarea></p>
    <p><input type="submit" value="отправить"></p>
</form>