<?php

use yii\bootstrap4\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?php ActiveForm::end(); ?>