<?$titlePage='Авторизация'?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<div id="page">
    <div id="whole">
<div class="post">
<form action="http://naitidruzei.ru/user/login/" method="post">
    <p class="error"><?=$this->error?></p>
    <p><b>Имя пользователя:</b></p>
    <p><input type="text" name="login" maxlength="19" size="40" value="<?=$worker->login?>"></p>
    <p><b>Пароль:</b></p>
    <p><input type="password" name="pass" size="40" maxlength="32"></p>
    <p><input type="submit" value="Войти"></p>
</form>
Вы у нас в первый раз? <a href="http://naitidruzei.ru/user/new/">Зарегистрируйтесь</a>, это займет не больше минуты!
<br/>
Забыли пароль? Восстановите его с помощью email.
</div>
</div>

    <!-- end #page -->
<?php include __DIR__ . '/../templates/templates_footer.php'; ?>