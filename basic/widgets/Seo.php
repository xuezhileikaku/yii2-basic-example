<?php


namespace app\widgets;


use yii\base\Widget;
use yii\helpers\ArrayHelper;

class Seo extends Widget
{
    public $model;
    private $title;
    private $keyWords;
    private $description;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if ($this->model !== null) {
            $m = $this->model;
            $this->title = $m->seo_title;
            $this->keyWords = $m->seo_keywords;
            $this->description = $m->seo_description;
        }
    }

    public function run()
    {
//        parent::run();
        return $this->title;
    }

    public static function seo($ob)
    {
        if ($ob !== null) {
            return ['title' => $ob->seo_title, 'keywords' => $ob->seo_keywords, 'description' => $ob->seo_description];
        }
        return ['title' => '', 'keywords' => '', 'description' => ''];
    }
}