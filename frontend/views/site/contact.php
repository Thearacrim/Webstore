<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Contact';
// $this->params['breadcrumbs'][] = $this->title;
// 
?>
<div class="site-contact">
    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Contact Us</h1>
            <p>
                Proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet.
            </p>
        </div>
    </div>

    <div id="map"></div>
    <!-- Replace the value of the key parameter with your own API key. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzv0A6cXOv-44v938KjWsj4hCqSbVGQA4&callback=initMap&v=weekly" defer></script>

    <!-- Start Contact -->
    <div class="container">
        <div class="row justify-content-center">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="input-group">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>
            </div>
            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!-- End Contact -->


</div>

<?php

$script = <<< JS

JS;
$this->registerJs($script);


?>