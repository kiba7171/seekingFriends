<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<form method="post">
    <p><b>Заголовок записи:</b></p>
    <p><textarea name="title" value="title" cols="100" rows="3"><?=$items->title?></textarea></p>
    <p><b>Текст статьи:</b></p>
    <p><textarea name="content" value="content" cols="100" rows="30"><?=$items->content?></textarea></p>
    <p><input type="submit" value="отправить"> <input type="submit" name="delete" value="удалить"></p>
</form>
</body>
</html>