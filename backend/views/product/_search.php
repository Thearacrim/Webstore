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
        'options' => ['id' => 'formOrderSearch', 'data-pjax' => true],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-4">
            <label>Date Range</label>
            <div id="order__date__range" style="cursor: pointer;" class="form-control">
                <i class="fas fa-calendar text-muted"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down text-muted float-right"></i>
            </div>
            <?= $form->field($model, 'from_date')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'to_date')->hiddenInput()->label(false) ?>
        </div>
        <div class="col-4">
            <div class="input-group input-group-sm">
                <?= $form->field($model, 'globalSearch')->textInput(['placeholder' => 'Search...', 'aria-label' => 'Search', 'type' => 'search', 'class' => 'form-control form-control-navbar rounded-0', 'style' => 'border-top-right-radius: 0;
                    border-bottom-right-radius: 0;'])->label(false) ?>
                <div class="input-group-addon">
                    <?= Html::submitButton('<i class="fas fa-search"></i> Search', [
                        'class' => 'btn btn-navbar bg-primary rounded-0',
                        'style' => '
                        border-top-left-radius: 0;
                        border-bottom-left-radius: 0;
                        color:#fff;
                        '
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-4">
            <p>
                <button type="button" value="<?= Url::to(['product/create']) ?>" class="btn btn-primary float-right btn1 rounded-circle action trigggerModal"><i class="fas fa-plus"></i></button>
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
    var is_filter = $("#articlesearch-from_date").val() != ''?true:false;

    if(!is_filter){
        var start = moment().startOf('week');
        var end = moment();
    }else{
        var start = moment($("#articlesearch-from_date").val());
        var end = moment($("#articlesearch-to_date").val());
    }

    function cb(start, end) {
        $('#order__date__range span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        $("#articlesearch-from_date").val(start.format('YYYY-MM-D'));
        $("#articlesearch-to_date").val(end.format('YYYY-MM-D'));
    }

    $('#order__date__range').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'This Week': [moment().startOf('week'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $('#order__date__range').on('apply.daterangepicker', function(ev, picker) {
        $('#formArticleSearch').trigger('submit');
    });

    $(document).on("change","#articlesearch-globalsearch", function(){
        $('#formArticleSearch').trigger('submit');
    });


    $(".triggerModal").click(function(){
        $("#modal").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        $("#modal").find("#modal-label").text($(this).data("title"));

    });
    JS;
$this->registerJs($script);

?>