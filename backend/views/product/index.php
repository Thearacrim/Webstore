<?php

use yii\bootstrap4\LinkPager;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    Modal::begin([
        'title' => 'Create new Product',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>

    <?php echo $this->render('_search', ['model' => $searchModel, 'class' => 'form-control inp']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{summary}\n{pager}",
        'pager' => ['options' => ['class' => 'pagination pull-right']],
        'pager' => [
            'prevPageLabel' => 'Previous',
            'nextPageLabel' => 'Next',
            'class' => LinkPager::class,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'status',
            // 'category_id',
            // [
            //     'attribute' => 'category_id',
            //     'label' => 'CategoryName',
            //     'contentOptions' => [
            //         'style' => 'width:60px;'
            //     ]
            // ],
            [
                'attribute' => 'price',
                'format' => ['currency'],
                'contentOptions' => [
                    'style' => 'width:100px;'
                ]
            ],
            [
                'attribute' => 'image_url',
                'label' => 'Image',
                'content' => function ($model) {
                    return Html::img($model->imageUrl, ['style' => 'width:50px;']);
                },
                'contentOptions' => [
                    'style' => 'width:50px;'
                ]

            ],
            [
                'attribute' => 'description',
                'format' => 'html',
            ],
            //'rate',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'header' => 'action'
            ],
        ],
    ]); ?>


</div>