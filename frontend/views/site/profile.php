<div class="container">
    <?php
    if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('alert')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('alert') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <?php

    use yii\bootstrap4\ActiveForm;
    use yii\bootstrap4\Html;

    $base_url = Yii::getAlias("@web");

    $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="row m-3">
        <div class="col-lg-2 col-md-12 col-sm-12 border border-dark">
            <div class="text-center p-3">
                <div class="profile_user border rounded-circle text-center">
                    <img id=img src="<?= $base_url ?>/profile/uploads/<?= $model->image_url ?>" class="image-profile">
                    <?= $form->field($model, 'image_url')->label('image_url', ['class' => 'form-control iput_upload', 'id' => 'input'])
                        ->fileInput(['onchange' => 'file_changed()', 'class' => 'sr-only']) ?>
                    <i class=" icon-upload fas fa-camera"></i>
                </div>
                <h4><?= Yii::$app->user->identity->username ?></h4>
            </div>
        </div>
        <div class=" col-lg-10 col-md-12 col-sm-12 border border-dark p-3 border-bottom">
            <div class="text-center">
                <h2>Profile User</h2>
                <p>Add information about your</p>
            </div>
            <hr class="w-100 bg-dark">

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

<?php
$script = <<< JS
    
    JS;
$this->registerJS($script);

?>