<?php
/**
 * Created by PhpStorm.
 * User: Rikipm
 * Date: 14.05.2019
 * Time: 21:59
 */
namespace rikipm\oggenerator\oggenerator;

use yii\base\Component;
use Yii;
use yii\base\ErrorException;

class oggenerator extends Component
{

    public $attr_title;
    public $attr_type;
    public $attr_image;
    public $attr_image_alt;

    public $attr_description;
    public $locale;
    public $site_name;

    public function generate($model)
    {
        Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $model->getAttribute($this->attr_title)]);
        Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => $model->getAttribute($this->attr_type)]); //We dont use static or constant variable from model class for "og:type" header because different instances of one model can have multiple types
        Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $model->getAttribute($this->attr_image)]);
        Yii::$app->view->registerMetaTag(['property' => 'og:image:alt', 'content' => $model->getAttribute($this->attr_image_alt)]);
        Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->request->getAbsoluteUrl()]);

        Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $model->getAttribute($this->attr_description)]);
        Yii::$app->view->registerMetaTag(['property' => 'og:locale', 'content' => $this->locale]);
        Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => $this->site_name]);

        try //Trying to generate additional image tags
        {
            $image_info = getimagesize($model->getAttribute($this->attr_image));

            Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => $image_info[0]]);
            Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => $image_info[1]]);
            Yii::$app->view->registerMetaTag(['property' => 'og:image:type', 'content' => $image_info['mime']]);
        }
        catch (ErrorException $e)
        {
            //If opening image failed do nothing
        }

    }
}
