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
    <h1 class="text-center pt-5 pb-5">Messages</h1>
    <!-- Start Contact -->
    <div class="container">
        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model, 'email') ?>
                    </div>
                </div>
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
                <script src="https://www.google.com/recaptcha/api.js"></script>
                <div class="g-recaptcha pt-5 pb-5" data-sitekey="6Ld77J8fAAAAAPoq_6VzMGlm-bxYkRtP2k2Q2V5s"></div>
            </div>
            <div class="col-lg-6">
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!-- End Contact -->


</div>

<?php

$script = <<< JS
// function onClick(e) {
//         e.preventDefault();
//         grecaptcha.ready(function() {
//           grecaptcha.execute('6Ld77J8fAAAAAPoq_6VzMGlm-bxYkRtP2k2Q2V5s', {action: 'submit'}).then(function(token) {
//               // Add your logic to submit to your backend server here.
//           });
//         });
//       }
function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
JS;
$this->registerJs($script);


?>