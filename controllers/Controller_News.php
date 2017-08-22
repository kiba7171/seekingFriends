<?php
use Application\Models\News;
use Application\Models\Comments;

class Controller_News
{

    // Получаем и выводим все статьи из БД
    public function action_all()
    {
        // Количество статей на страницу.
        $count = isset($_GET['count']) ? $_GET['count'] : 5;

        // Смещение для БД
        $start = isset($_GET['start']) ? $_GET['start'] : 0;

        // Получаем общее кол-во "страниц" на сайте
        $worker = new News;
        $all = $worker->getNumRows();

        // Получаем результат запрса по нашей выборке
        $items = $worker->selectLimit($count, $start);

        // Создаем блок ссылок с постраничной навигацией:
        $pagenav = new SimPageNav();

        // Формирурем шаблон вывода
        $viewer = new Views;
        $viewer->items = $items;
        $viewer->pagenav = $pagenav->getLinks($all, $count, $start, 10, 'start' );
        $viewer->display ('all_views');
    }

    // Выводим одну статью + комментарии
    public function action_one()
    {
        // Получаем все комментарии для указанной статьи
        $comments = Comments::getComments($_GET['id']);

        // Получаем статью
        $items = News::get_one($_GET['id']);

        // Формируем шаблон вывода
        $viewer = new Views;
        $viewer->items = $items;
        $viewer->comments = $comments;

        // Если был отправлен комментарий к статье - запускаем функуцию обработчик
        if(!empty($_POST))
        {
            $viewer->name = $_POST['name'];
            $viewer->email = $_POST['email'];
            $viewer->text = $_POST['text'];
            $viewer->error = Controller_comment::newComment();
        }

        // Выводим
        $viewer->display ('articles_views');
    }

}