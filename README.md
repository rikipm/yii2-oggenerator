# yii2-oggenerator
Its simple Yii2 component that generates [OpenGraph](http://ogp.me/) tags for your models pages

# Installation
The preferred way to install this extension is through composer.

Either run

```
composer require --prefer-dist "rikipm/yii2-oggenerator" "*"
```
or add

```
"rikipm/yii2-oggenerator" : "*"
```
to the require section of your application's `composer.json` file.

# Usage

Add new component to `components` section of your application config and configure it

```php
'oggenerator'=>[
            'class' => 'rikipm\oggenerator',

            'locale' => 'en-US', //Its "og:locale" tag for all pages
            'site_name' => 'MySite',  //Its "og:site_name" tag for all pages

            'attr_title' => 'title',
            'attr_type' => 'type',
            'attr_image' => 'image',
            'attr_image_alt' => 'image_alt',
            'attr_description' => 'description',
        ],
```

`attr_` options will determine what attribute from model will be used for content of tag. 
In example `'og:title'` will assigned `$model->title` value, `'og:image'` will assigned `$model->image` value, etc.

`og:url` ,`og:image:type`, `og:image:width` and `og:image:height` tags will be generated automatically.



In controller that display your page add `Yii::$app->oggenerator->generate($model);`

For example:
```php
public function actionView($id)
{
  $model = Model::findOne(['id' => $id]);

  Yii::$app->oggenerator->generate($model);
  return $this->render('view', ['model' => $model]);
}
```

**Attention!**

`og:image` must be **absolute** url. You can use getters in model class to generate value

For example:
```php
public getImage()
{
  return Url::home().'/upload/'.$model->image_file;
}
``
