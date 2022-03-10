<div class="container">
    <?php
    if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <div class="row m-3">
        <div class="col-4 border border-dark">
            <div class="text-center p-3">
                <img class="img-profile1 rounded-circle" src='https://img-c.udemycdn.com/user/200_H/151754832_2d1f_2.jpg' alt='' alt="">
                <h4><?= Yii::$app->user->identity->username ?></h4>
            </div>
        </div>
        <div class=" col-8 border border-dark p-3 border-bottom">
            <div class="text-center">
                <h2>Profile User</h2>
                <p>Add information about your</p>
            </div>
            <hr class="w-100 bg-dark">
            <?php

            use yii\bootstrap4\ActiveForm;
            use yii\bootstrap4\Html;

            $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <hr class="bg-dark">

            <div class="text-center">
                <?= Html::submitButton('Update', ['class' => 'btn rounded-0 btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>