<?php
use Application\Models\News;
use Application\Models\Add;

Class Controller_add

{
    public $error;
    public $title;
    public $text;
    public $img;

    // Добавление новой записи
    public function action_new()
    {
        session_start();
        // Сохраняем введенные в форму данные
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Если пользователь не авторизован - отправляем на форму авторизации.
        if (!empty($_SESSION))
        {
            // Загрузчик изображений
            if (is_uploaded_file($_FILES['image']['tmp_name']))
            {

                // Проверки загружаемого файла
                $check = new Add;
                $error = $check->check_img($_FILES);

                // Если проверки пройдены - перекидываем на сервер
                if(empty($error))
                {
                    // Получаем расширение загруженного файла
                    $extension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                    //собираем путь к папке с изображениями
                    $path = __DIR__ . '/../upload/news_img';

                    // Генерируем уникальное имя файла с этим расширением
                    $filename = $check->getRandomFileName($path, $extension);

                    // Собираем полный адрес с новым именем
                    $target = $path . '/' . $filename . '.' . $extension;

                    // Запоминаем в сессию имя файла
                    $_SESSION['img_name'] = $filename . '.' . $extension;

                    // Сохраняем изображение на сервере с ресайзом 650х650
                    $image = new \Eventviva\ImageResize($_FILES['image']['tmp_name']);
                    $image->resizeToBestFit(650, 650);
                    $image->save($target);

                    // Собираем путь до миниатюр
                    $path2 = __DIR__ . '/../upload/news_img/250x250';
                    $target2 = $path2 . '/' . $filename . '.' . $extension;

                    // Делаем и сохраняем миниатюры
                    $image = new \Eventviva\ImageResize($target);
                    $image->resizeToBestFit(300, 300);
                    $image->save($target2);
                }

                // Если нет - выводим ошибку
                else
                {
                    $data['errors'] = $error;
                }



                // Данные для js
                $res = '<script type="text/javascript">';
                $res .= "var data = new Object;";
                foreach($data as $key => $value)
                {
                    $res .= 'data.'.$key.' = "'.$value.'";';
                }
                $res .= 'window.parent.handleResponse(data);';
                $res .= "</script>";
                echo $res;
            }

            // Если обе формы заполнены - обрабатываем данные
            if (!empty($_POST['title']) && !empty($_POST['content']))
            {
                // Готовим данные для добавления в БД
                $article = new Add;
                $article->title = $_POST['title'];
                $article->content = $_POST['content'];
                $article->date = date('d.m.Y H:i');
                $article->userName = $_SESSION['user'];

                // Проверяем загружалась ли картинка
                if (!empty($_SESSION['img_name']))
                {
                    $article->img_name = $_SESSION['img_name'];
                    unset($_SESSION['img_name']);
                }

                // Сохраняем все данные в базу
                $article->save();
                ?>

                <script type="text/javascript">
                alert( "Ваше объявление было отправлено на проверку модератору, оно появится на сайте в самое ближайшее время." );
                </script>

                <?
            }

            //Выводим ошибку если одно из полей пустое
            else if (empty($_POST['title']) xor empty($_POST['content']))
            {
                $this->error = 'Заполните все поля!';
            }
            require_once __DIR__ . '/../views/add_views.php';
        }

        // Отправляем на форму авторизации
        else
        {
            $this->error = 'Добавлять объявленя могут только зарегистрированные пользователи.
            Пожалуйста зарегистрируйтесь или зайдите под своим логином.';

            include_once __DIR__ . '/../views/login_views.php';
        }
    }

    // Удаление статьи
    public function deleteNews()
    {
        $id = new Add;
        $id->id_article = $_GET['id'];
        $id->deleteNews();
    }

    //Вывод всех статей в админке
    public function action_all()
    {
        $items = News::get_all();
        $viewer = new Views;
        $viewer->items = $items;
        $viewer->display ('all_admin_views');
    }

    //Редактирование статьи
    public function action_update()
    {
        $items = News::get_one($_GET['id']);
        $viewer = new Views;
        $viewer->items = $items;
        $viewer->display ('edit_views');

        //Обрабатываем нажатие кнопки "удалить"
        if (!empty($_POST['delete']))
        {
            $delete = new Controller_add;
            $delete->deleteNews();
        }

        //Сохраняем изменения
        if (!empty($_POST['title']))
        {
            $article = new Add;
            $article->title = $_POST['title'];
            $article->content = $_POST['content'];
            $article->id_article = $_GET['id'];
            $article->save();
        }
    }

}