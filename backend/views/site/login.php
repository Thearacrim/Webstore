<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
?>
<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
</div>
<?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'user']]); ?>
<?= $form->field($model, 'username')->textInput(['class' => 'form-control form-control-user', 'placeholder' => 'Username or Email'])->label(false) ?>
<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-user', 'placeholder' => 'Enter your password'])->label(false) ?>

<?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login-button']) ?>

<?php ActiveForm::end(); ?>
<hr>
<div class="text-center">
    <a class="small" href="forgot-password.html">Forgot Password?</a>
</div>
<div class="text-center">
    <a class="small" href="register.html">Create an Account!</a>
</div>