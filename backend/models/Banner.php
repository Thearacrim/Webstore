<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $sort_description
 * @property string|null $description
 * @property string|null $image_banner
 */
class Banner extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['image', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
            [['title', 'sort_description'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['image_banner'], 'string']
        ];
    }

    public function getThumbUploadUrl()
    {
        $base_url_frontend = str_replace("backend", 'frontend', Yii::$app->request->baseUrl);
        if (!$this->image_banner) {
            return $base_url_frontend . '/uploads/placeholder.jpg';
        }
        return $base_url_frontend . '/' . $this->image_banner;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'sort_description' => 'Sort Description',
            'description' => 'Description',
            'image_banner' => 'Image Banner',
        ];
    }
}
