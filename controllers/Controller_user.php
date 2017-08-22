<?php
use Application\Models\Users;

class Controller_user
{
    public $error;


    //Регистрация нового пользователя
    public function action_new ()
    {
        // Сохраняем полученные из формы данные
        $worker = new Users;
        $worker->login = $_POST['login'];
        $worker->password = $_POST['pass'];
        $worker->email = $_POST['email'];

        //Если все поля заполнены
        if (!empty($_POST['login']) && !empty($_POST['email']))
        {
            // Проверка уникальности логина
            if($worker->findByColumn('login', $worker->login))
            {
                $this->error = 'Такой логин уже занят!';
            }

            // Проверка длины пароля
            elseif(strlen($worker->password) < 5)
            {
                $this->error = 'Пароль слишком короткий!';
            }

            // Запись данных в БД
            elseif($worker->add_one())
            {
                $this->error = 'Регистрация завершена. Добро пожаловать!';
            }

        }

        //Если поле формы не заполнено
        else if (!empty($_POST['login']) xor !empty($_POST['email']))
        {
            $this->error = 'Заполните все поля!';
        }

        require __DIR__ . '/../views/registr_views.php';
    }

    // Обрабатываем форму авторизации
    public function action_login ()
    {
        $worker = new Users;
        $worker->login = $_POST['login'];
        $worker->password = $_POST['pass'];

        // Проверяем соответствие "пароль/логин"
        $dataArray = $worker->findByColumn('login', $worker->login);
        foreach ($dataArray as $data)
        {
            $login = $data['Login'];
            $password = $data['Password'];
        }

        // Все совпало - стартуем сессию
        if($login === $worker->login && $password === $worker->password)
        {
            session_start();
            $_SESSION['user'] = $worker->login;
            header('Location: http://vesta-clubs.ru/index.php');
        }

        // Данные не совпали
        else
        {
            $this->error = 'Не верные данные!';
            include_once __DIR__ . '/../views/login_views.php';
            // header('Location: http://vesta-clubs.ru/index.php');
        }

    }

}