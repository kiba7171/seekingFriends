<?php
Class Views
{
    public $pagenav;
    protected $data = [];

    // Выводим заданный в контроллере шаблон и данные
    public function display ($view_path)
    {

        //var_dump($this->data);
        foreach ($this->data as $key => $val)
        {
            $$key = $val;
        }

        include __DIR__ . '/../views/' . $view_path . '.php';
    }

    public function __set ($n, $v)
    {
        $this->data[$n] = $v;
    }
}