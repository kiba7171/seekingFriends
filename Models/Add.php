<?php
Namespace Application\Models;

class Add
extends \Abstract_model
{
    protected static $table = 'Articles';

    //При возникновении "исключения" записываем ошибку в лог
    public static function AddLogs ($message, $system)
    {
        file_put_contents ( 'logs.txt', date('jS \of F Y h:i:s A  | ') . $system . $message . "\n", FILE_APPEND | LOCK_EX);
        header('Location: views/404.php');
    }

}