<div id="sidebar">
    <div class="sidebar-block">
    <ul>
        <li>
            <h2>Авторизуйтесь:</h2>
            <ul>
                <form action="http://naitidruzei.ru/user/login/" method="post">
                    <p><b>Имя пользователя:</b></p>
                    <p><input type="text" name="login" maxlength="19" size="20" value="<?=$worker->login?>"></p>
                    <p><b>Пароль:</b></p>
                    <p><input type="password" name="pass" size="20" maxlength="32"></p>
                    <p><input type="submit" value="Вход"></p>
                </form>
            </ul>
        </li>
    </ul>
    </div>

    <div class="sidebar-block">
    <h2>Место для котиков:</h2>
    <img src="http://naitidruzei.ru/images/kotiki2.jpg">
    </div>

</div>
<!-- end #sidebar -->
<div style="clear: both;">&nbsp;</div>

<?php
session_start();
?>