<?php
use Application\Models\News;
use Application\Models\Add;
use Application\Models\Comments;

Class Controller_admin

//Админка
{

    // Удаление статьи
    public function deleteNews()
    {
        Controller_admin::check_user();
        $id = new Add;
        $id->id_article = $_GET['id'];
        $id->deleteNews();
    }

    //Вывод всех статей в админке
    public function action_all()
    {
        Controller_admin::check_user();
        $items = News::get_all();
        $viewer = new Views;
        $viewer->items = $items;
        $viewer->display ('all_admin_views');
    }

    //Редактирование статьи
    public function action_update()
    {
        Controller_admin::check_user();
        $items = News::get_one($_GET['id']);
        $viewer = new Views;
        $viewer->items = $items;
        $viewer->display ('edit_views');
        if (!empty($_POST['delete']))
        {
            $delete = new Controller_add;
            $delete->deleteNews();
        }
        if (!empty($_POST['title']))
        {
            $article = new Add;
            $article->title = $_POST['title'];
            $article->content = $_POST['content'];
            $article->id_article = $_GET['id'];
            $article->save();
        }
    }

    //Если в админке не администартор - редирект на главную
    static function check_user()
    {
        session_start();
        if ($_SESSION['user'] !== 'Admin_Gena')
            header("Location: http://vesta-clubs.ru");
    }

}