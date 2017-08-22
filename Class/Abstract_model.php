<?php

abstract class Abstract_model
{
    static protected $table;
    protected $data = [];

    public function __set ($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function __get ($k)
    {
        return $this->data[$k];
    }

    public function __isset ($k)
    {
        return isset($this->data[$k]);
    }

    //Функция получения всех строк из указанной в моделе таблицы
    public static function get_all()
    {
        $class = get_called_class();
        $db = new Base_Work ();
        $db -> get_className ($class);
        $res = $db->query_class('SELECT * FROM ' . static::$table . ' ORDER BY id_article  DESC');
        if (empty($res))
        {
            $eror404 = new E404Exception();
            throw $eror404;
        }
        else
        {
            return $res;
        }
    }

    //Получение всех строк с одним совпадением
    public static function getComments($id)
    {
        $class = get_called_class();
        $db = new Base_Work ();
        $db -> get_className ($class);
        $res = $db->query_class('SELECT * FROM ' . static::$table . ' WHERE id_news=:id', [':id'=> $id] );
            return $res;
    }

    //Получение одной строки из БД
    public static function get_one($id)
    {
        $class = get_called_class();
        $db = new Base_Work ();
        $db -> get_className ($class);
        $res = $db->query_class('SELECT * FROM ' . static::$table . ' WHERE id_article=:id', [':id'=> $id])[0];
        if (empty($res))
        {
            $eror404 = new E404Exception();
            throw $eror404;
        }
        else
        {
            return $res;
        }
    }

    //Добавление строки в БД
    public function add_one ()
    {
        $cols = array_keys($this->data);
        $ins = [];
        $data = [];
        foreach ($cols as $col)
        {
            $ins[] = ':' . $col;
            $data[':' . $col] = $this->data[$col];
        }
        $db = new Base_Work ();
        $db->add_articles('INSERT INTO ' . static::$table . ' (' . implode (', ', $cols). ') VALUES (' . implode (', ', $ins). ')',
            $data);
      return $this->id_article = $db->lastInsertId ();
    }

    // Поиск точного совпадения по базе
    public static function findByColumn ($column, $value)
    {
        $class = get_called_class();
        $db = new Base_Work ();
        $db -> get_className ($class);
        return $db->query('SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' LIKE :value', [':value'=> $value]);
    }

    // Поиск частичнго совпадения
    public static function ExtendedSearchByColumn ($column, $value)
    {
        $class = get_called_class();
        $db = new Base_Work ();
        $db -> get_className ($class);
        return $db->query('SELECT * FROM ' . static::$table . ' WHERE ' . $column . ' LIKE :value', [':value'=> '%' . $value . '%']);
    }

    //Редактирование строки в БД
    public function updateNews ()
    {
        $cols = array_keys($this->data);
        $ins = [];
        $data = [];
        foreach ($cols as $col)
        {
            $ins[] = $col . '=:' . $col;
            $data[':' . $col] = $this->data[$col];
        }

        $db = new Base_Work ();
        $db->query_class('UPDATE ' . static::$table . ' SET ' . implode (', ', $ins) . ' WHERE id_article=:id_article',
            $data);
    }

    //Удаление строки из БД
    public function deleteNews ()
    {
        $cols = array_keys($this->data);
        $ins = [];
        $data = [];
        foreach ($cols as $col)
        {
            $ins[] = ':' . $col;
            $data[':' . $col] = $this->data[$col];
        }
        $db = new Base_Work ();
        $db->query_class('DELETE FROM ' . static::$table . ' WHERE ' . $cols[0] . '=:' . $cols[0], $data);
    }

    //Автовыбор(добавление новой/обновления старой)
    public function save()
    {
        if (isset ($this->id_article))
        {
            $this->updateNews();
        }
        else
        {
            $this->add_one();
        }
    }

    //Проверки перед загрузкой изображения
    public function check_img($files)
    {
        // Проверяем на тип файл
        $whitelist = array(".gif", ".jpg", ".jpeg", ".png");

        foreach  ($whitelist as  $item)
        {
            if(preg_match("/[^$item]\$/i",$files['image']['name']))
            {
                return $error = 'неверный формат изображения!';
            }

        }

        // Проверяем размер файла
        if (filesize ($files['image']['tmp_name']) > 2578078)
        {
            return $error = 'превышен допустимый размер изображения (не более 2 мб).';
        }
    }

    //Генерация уникально имени для файла
    public function getRandomFileName($path, $extension='')
    {
        $extension = $extension ? '.' . $extension : '';
        $path = $path ? $path . '/' : '';

        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));

        return $name;
    }

    //Получение кол-ва строк
    public function getNumRows ()
    {
        $db = new Base_Work ();
        return $db->query_num('SELECT COUNT(*) as count FROM ' . static::$table);

    }

    //Получение данных с лимитами
    public function selectLimit ($limit, $offset)
    {
        $db = new Base_Work ();
        return $db->query_limit('SELECT * FROM ' . static::$table .
            ' ORDER BY id_article  DESC LIMIT :limit OFFSET :offset', $limit, $offset);
    }


    //Получение количества строк при сборе данных по критериям
    public function getNumRowsSearch ($criterion)
    {
        $var = [];
        $result = [];
        //Создаем массив с параметрами для запроса
        $cols = array_keys($criterion);
        for($i=0; $i<=(count($cols)-1); $i++)
        {
            $result[':' . $cols[$i]] = $criterion[$cols[$i]];
        }

        //Комбинируем данные для подстановки в запрос
        for($i=0; $i<=(count($cols)-1); $i++)
        {
            $var[] = $cols[$i] . '=:' . $cols[$i];
        }

        $var = implode(' AND ', $var);
        $db = new Base_Work ();
        return $db->query_num('SELECT COUNT(*) as count FROM ' . static::$table . ' WHERE ' . $var, $result);
    }


    //Получение данных с лимитами по критериям
    public function selectLimitSearch ($limit, $offset, $criterion)
    {
        $var = [];
        $result = [];
        //Создаем массив с параметрами для запроса
        $cols = array_keys($criterion);
        for($i=0; $i<=(count($cols)-1); $i++)
        {
            $result[':' . $cols[$i]] = $criterion[$cols[$i]];
        }

        //Комбинируем данные для подстановки в запрос
        for($i=0; $i<=(count($cols)-1); $i++)
        {
            $var[] = $cols[$i] . '=:' . $cols[$i];
        }

        $var = implode(' AND ', $var);
        $db = new Base_Work ();
        return $db->query_limitSearch('SELECT * FROM ' . static::$table . ' WHERE ' . $var .
       ' ORDER BY id_article  DESC LIMIT :limit OFFSET :offset', $limit, $offset, $result);
    }

    //Получение одного столбца из таблицы
    public function selectColumns ($columns)    {
        $class = get_called_class();
        $db = new Base_Work ();
        $db -> get_className ($class);
        $res = $db->query_class('SELECT ' . $columns . ' FROM ' . static::$table . ' WHERE ' . $columns . '!=:id', [':id'=> ""]);
        return $res;
        }
}
