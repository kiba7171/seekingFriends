<?php
namespace Application\Models;

class News
extends \Abstract_model
{
    public $title;
    public $content;
    public $id_article;
    protected static $table = 'Articles';


}