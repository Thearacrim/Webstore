<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use dosamigos\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    <br>
    <?= $form->field($model, 'image_url')->label('image_url', ['class' => 'form-control'])
        ->fileInput(['class' => 'sr-only']) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ])  ?>

    <?= $form->field($model, 'rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type_item')->dropDownList(['1' => 'Women', '2' => 'Man', '3' => 'Sport', '4' => 'Bag', '5' => 'watch', '6' => 'Shores'], ['prompt' => 'Type Item']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$script = <<< JS
    $('.isSelect2').select2({
        placeholder: "Select a state",
        width: "100%",
    });
    JS;
$this->registerJs($script);

?>