<?php
require_once __DIR__ . '/../autoload.php';
use Application\Models\News;

class Controller_search
{
    protected $data = [];

    public function get_city()
    {
        $array_city = array();
        $worker = new News;
        //Получаем все данные с БД из указанной колонки
        $this->data = $worker->selectColumns('city');
        //Обрабатываем полученные данные и складываем в массив
        foreach ($this->data as $key => $val)
        {
            $array_city[] .= $val->city;
        }
        //Удаляем дубликаты и сортируем по алфавиту
        $array_city = array_unique($array_city);
        sort($array_city);
        return $array_city;
    }

    public function action_search()
    {
        //var_dump($_POST);

        //Складываем в массив выбранные параметры сортировки
        $arr = [];
        foreach($_POST as $key => $val)
        {
            if ($val != '0') {
                $arr[$key] = $val;
            }
        }

        //Если параметры не выбраны - редирект на главную
        if(empty($arr))
        {
            header('Location: http://naitidruzei.ru');
        }
        else
        {
            // Количество статей на страницу.
            $count = isset($_GET['count']) ? $_GET['count'] : 5;
            // Смещение для БД
            $start = isset($_GET['start']) ? $_GET['start'] : 0;

            $worker = new News;

            //Получаем кол-во строк по нашей выборке
            $all = $worker->getNumRowsSearch($arr);

            // Получаем результат запрса по нашей выборке
            $items = $worker->selectLimitSearch($count, $start, $arr);

            // Создаем блок ссылок с постраничной навигацией:
            $pagenav = new SimPageNav();

            // Формирурем шаблон вывода
            $viewer = new Views;
            $viewer->items = $items;
            $viewer->pagenav = $pagenav->getLinks($all, $count, $start, 10, 'start' );
            $viewer->display ('all_views');
        }

    }

}

if($_POST['query'] == 1)
{

    $query = new Controller_search();
    $result = $query->get_city();
    echo json_encode($result);
}
