<?php
use Application\Models\Comments;

class Controller_comment
{
    public $error;

    //Добавление нового комментария
    static function newComment ()
    {
        // Сохраняем введенные в форму данные
        $name = $_POST['name'];
        $email = $_POST['email'];
        $text = $_POST['text'];

        // Проверяем заполнены ли все поля формы
        if(empty($name))
        {
           return $error = 'Введите свое имя!';
        }

        elseif(empty($email))
        {
            return $error = 'Введите свою почту!';
        }

        elseif(empty($text))
        {
            return $error = 'Введите комментарий!';
        }

        // Если все поля заполнены - сохраняем в БД
        else
        {
            $content = new Comments;
            $content->name = $name;
            $content->email = $email;
            $content->text = $text;
            $content->id_news = $_GET['id'];
            $content->date = date('d.m.Y H:i');
            $content->save();
            header('Location: http://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'] . '#comments');
        }
    }

}