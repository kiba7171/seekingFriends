<?php
use Application\Models\Add;
class Base_Work
{

    public $title;
    public $content;
    public $id;
    private $logDir;
    private $dbh;
    private $className = 'stdClass';

    // При создании объекта - соединяемся с БД
    public function __construct()
    {
        $hostname = 'localhost';
        $username = 'postavto_fineGR';
        $password = 'RhjkbrAfyz1991';
        $dbName = 'postavto_fineGR';

        $pdoAttributes = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );
        $dsn = 'mysql:host=localhost;dbname=postavto_fineGR';
        $this->dbh = new PDO($dsn, $username, $password, $pdoAttributes);

        $this->logDir = __DIR__ . '/../logs.txt/';
    }


    //Выполняем запрос к БД (FETCH_CLASS)
    public function query_class($sql, $params=[])
    {
        try
        {
          $sth = $this->dbh->prepare($sql);
          $sth->execute($params);
          return $sth->fetchAll(PDO::FETCH_CLASS, $this->className);
        }

        catch (PDOException $e)
        {
            Add::AddLogs($e->getMessage(), 'PDOException: ');
        }
    }

    //Выполняем запрос к БД (FETCH_ASSOC)
    public function query($sql, $params=[])
    {
        try
        {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        }

        catch (PDOException $e)
        {
            Add::AddLogs($e->getMessage(), 'PDOException: ');
        }
    }

    //Выполняем запрос к БД (fetchColumn)
    public function query_num($sql, $params=[])
    {
        try
        {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            return $sth->fetchColumn();
        }

        catch (PDOException $e)
        {
            Add::AddLogs($e->getMessage(), 'PDOException: ');
        }
    }

    //Выполняем запрос к БД с лимитами
    public function query_limit($sql, $limit, $offset)
    {
        try
        {
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $sth->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_CLASS, $this->className);

        }

        catch (PDOException $e)
        {
            Add::AddLogs($e->getMessage(), 'PDOException: ');
        }
    }

    //Выполняем запрос к БД с лимитами и критериями
    public function query_limitSearch($sql, $limit, $offset, $params=[])
    {
        try
        {
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $sth->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            foreach($params as $key => $val)
            {
                $sth->bindValue($key, $val);
            }
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_CLASS, $this->className);
        }

        catch (PDOException $e)
        {
            Add::AddLogs($e->getMessage(), 'PDOException: ');
        }
    }

    //Сохраняем данные в БД
    public function add_articles($sql, $params=[])
    {
        try
        {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
        }
        catch (PDOException $e)
        {
            Add::AddLogs($e->getMessage(), 'PDOException: ');
        }
    }

    //Получаем id последней добвылкнно   строки
    public function lastInsertId ()
    {
        return $this->dbh->lastinsertid();
    }

    //Получаем имя вызываюшего класса
    public function get_className ($class)
    {
        $this->className = $class;
    }
}
