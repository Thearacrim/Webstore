<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $status
 * @property int|null $category_id
 * @property string|null $price
 * @property string|null $image_url
 * @property string|null $description
 * @property float|null $rate
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'description', 'price', 'status', 'rate'], 'required'],
            [['category_id'], 'integer'],
            [['image_url'], 'file'],
            // [['image_url'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['rate'], 'number'],
            [['status', 'image_url', 'description'], 'string', 'max' => 255],
            [['price'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'price' => 'Price',
            'image_url' => 'Image Url',
            'description' => 'Description',
            'rate' => 'Rate',
        ];
    }

    public function getImageUrl()
    {
        return str_replace("backend", 'frontend', Yii::$app->request->baseUrl) . "/" . $this->image_url;
    }
}
