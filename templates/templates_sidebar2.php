<div id="sidebar">
    <ul>
        <li>
            <h2>Добро пожаловать!</h2>
            <ul>
            <li>Привет, <?=$_SESSION['user']?>!</li>
            <li> Личных сообщений = 0</li>
            </ul>
        </li>
    </ul>
</div>
<!-- end #sidebar -->
<div style="clear: both;">&nbsp;</div>
<?php
session_start();
?>