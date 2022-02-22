<?php

use yii\helpers\Html;
use backend\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

AppAsset::register($this);


/* @var $this yii\web\View */
/* @var $model backend\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'options' => ['id'=> 'formOrderSearch', 'data-pjax'=>true],
        'method' => 'get',
    ]); ?>

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm">
                    <?= $form->field($model, 'globalSearch')->textInput(['placeholder' =>'Search...','aria-label'=>'Search','type'=>'search','class'=>'form-control form-control-navbar','style'=>'border-top-right-radius: 0;
                    border-bottom-right-radius: 0;'])->label(false) ?>
                    <div class="input-group-addon">
                        <?= Html::submitButton('<i class="fas fa-search"></i> Search', [
                        'class' => 'btn btn-navbar bg-primary',
                        'style'=>'
                        border-top-left-radius: 0;
                        border-bottom-left-radius: 0;
                        color:#fff;
                        ']) ?>                  
                    </div>
                </div>
            </div>
            <div class="col-6">
                <p>
                    <button type="button" value="<?= Url::to(['product/create'])?>" class="btn btn-primary float-right btn1 rounded-circle action trigggerModal"><i class="fas fa-plus"></i></button>
                </p>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

    $script = <<< JS
    $(document).on("click",".trigggerModal",function(){
        $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));
    });

    JS;
    $this->registerJs($script);

?>
