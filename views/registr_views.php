<?$titlePage='Регистрация нового пользователя'?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<div id="page">
    <div id="whole">
<div class="post">
    <form method="post">
        <p class="error"><?=$this->error?></p>
        <p><b>Имя пользователя:</b></p>
        <p><input type="text" name="login" maxlength="19" size="40" value="<?=$worker->login?>"></p>
        <p><b>Пароль:</b></p>
        <p><input type="password" name="pass" size="40" maxlength="32"></p>
        <p><b>Email:</b></p>
        <p><input type="email" name="email" size="40" value="<?=$worker->email?>"></p>
        <p><input type="submit" value="Зарегистрироваться"></p>
    </form>
</div>
</div>
    <!-- end #page -->
<?php include __DIR__ . '/../templates/templates_footer.php'; ?>