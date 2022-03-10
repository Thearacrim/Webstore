<?php

use backend\models\Cart;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$base_url = Yii::getAlias("@web");
// $carts = Cart::find()->where(['user_id' => Yii::$app->user->id])->all();
// foreach ($carts as $cart) {
//     echo ($cart->product->price * $cart->quantity) . "<br/>";
// }
?>

<div class="container">
    <div class="cart-main">
        <div class="row">
            <div class="col-8">
                <div class="card-header border">
                    <h2>Items</h2>
                </div>
                <div class="card-body border">
                    <?php
                    if ($totalCart) {
                        echo "<span id ='available_item'></span>";
                    } else {
                        echo "<span id ='available_item'>There are no items available</span>";
                    }
                    ?>
                    <?php foreach ($relatedProduct as $key => $product) { ?>
                        <div class="sec-border row_item_<?= $product['cart_id'] ?> rounded-0 hover p-3">
                            <div class="row ">
                                <div class="col-3">
                                    <img src="<?= $base_url . '/' . $product['image_url'] ?>" style="width:100px">
                                </div>
                                <div class="col-6">
                                    <span class="status"> <?= $product['status'] ?>
                                    </span><br>
                                    <span class="price"> $<?= $product['price'] ?></span><br><br>
                                    <?php echo Html::a(
                                        'Save',
                                        ['save', 'id' => $product['id']],
                                        [
                                            'class' => 'btn btn-outline-danger btn-sm',
                                            'date-method' => 'POST'
                                        ]
                                    ) ?> <?php echo Html::a(
                                                'Remove',
                                                ['remove', 'id' => $product['cart_id']],
                                                [
                                                    'class' => 'btn btn-outline-danger btn-sm btn-remove-item',
                                                    'date-method' => 'POST', 'data-id' => $product['cart_id']
                                                ]
                                            ) ?>
                                </div>
                                <div class="qty col-3 center d-inline py-5">
                                    <span class="minus bg-dark spinner item-quantity" data-product_id="<?= $product['id'] ?>" data-id=<?= $product['cart_id'] ?>>-</span>
                                    <input type="number" min='1' id="item-quantity_<?= $product['cart_id'] ?>" class="count item-quantity" name="qty" value="<?= $product['quantity'] ?>">
                                    <span class="plus bg-dark spinner item-quantity" data-product_id="<?= $product['id'] ?>" data-id=<?= $product['cart_id'] ?>>+</span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
            <div class="col-4 border rounded h-auto">
                <div class="row ">
                    <div class="card-header w-100 mb-3">
                        <h4>Price Detail</h4>
                    </div>
                    <div class="card-body">
                        <h4>Subtotal(<span id="amount-item"><?= $totalCart ?></span>): $ <span id='amount-price'><?= $totalPrice ?></span></h4>
                        <hr>
                        <a href="<?= Url::to(['site/checkout']) ?>"><button class="btn btn-primary rounded-0 btn-lg w-100 mt-3">CheckOut</button></a>
                        <hr>
                    </div>
                </div><br>
            </div>
        </div>
    </div>
</div>

<?php
$change_quantity_url = Url::to(['site/change-quantity']);

$script = <<< JS
        const change_quantity_url = "$base_url";
        
        // input spinner

            $(document).ready(function(){
                $('.count').prop('disabled', true);
                $(document).on('click','.plus',function(){
                    var id = $(this).data("id");
                    var qty = parseInt($("#item-quantity_"+id).val()) + 1;
                    $("#item-quantity_"+id).val(qty);
                    var product_id = $(this).data("product_id");
                     $.ajax({
                            url: '$change_quantity_url',
                            method: 'POST',
                            data: {
                                id: product_id,
                                type: 'add',
                                action: 'item-quantity'
                            },
                            success: function(res){
                                var data = JSON.parse(res);
                                if(data['status'] == 'success'){
                                    $("#amount-price").text(data['totalPrice_in_de_remove']);
                                    $("#cart-quantity").text(data['totalCart']);
                                }else{
                                    alert(data['message']);
                                }
                            },
                            error: function(err){
                                console.log(err);
                            }
                    });
                });
                $(document).on('click','.minus',function(){
                    var id = $(this).data("id");
                    var qty = parseInt($("#item-quantity_"+id).val()) - 1;
                    var product_id = $(this).data("product_id");
                    $("#item-quantity_"+id).val(qty);
                        $.ajax({
                            url: '$change_quantity_url',
                            method: 'POST',
                            data: {
                                id: product_id,
                                type: 'minus',
                                action: 'item-quantity'
                            },
                            success: function(res){
                                var data = JSON.parse(res);
                                // console.log(data);
                                if(data['status'] == 'success'){
                                    $("#amount-price").text(data['totalPrice_in_de_remove']);
                                    $("#cart-quantity").text(data['totalCart']);
                                }else{
                                    alert(data['message']);
                                }
                            },
                            error: function(err){
                                console.log(err);
                            }
                    });
                    });
            });

            // btn-remove section
        $('.btn-remove-item').click(function(e){
            e.preventDefault();
            var id = $(this).closest('.btn-remove-item').data('id');
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    id: id,
                    action: 'btn_remove_item',
                },
                success: function(res){
                    var data = JSON.parse(res);
                    console.log(data);
                    $("#available_item").text(data['available_item']);
                    $("#amount-item").text(data['totalItem']);
                    $("#amount-price").text(data['totalPrice_in_de_remove']);
                    $("#totalprice").text(data['totalPrice_in_de_remove']);
                    if(data['status'] == 'success'){
                        $(".row_item_"+id).remove();
                        $("#cart-quantity").text(data['totalCart']);
                    }
                },
                error: function(err){
                    console.log(err);
                }
        });
    });
    // $('.item-quantity').click(function(ev){
    //         var id = $(this).closest('.item-quantity').data('id');
    //         var qty =  $("#item-quantity_"+id).val();
    //         console.log(qty);
    //         return ;     
    //     $.ajax({
    //             url: '$change_quantity_url',
    //             method: 'POST',
    //             data: {
    //                 id: id,
    //                 action: 'item-quantity'
    //             },
    //             success: function(res){
    //                 var data = JSON.parse(res);
    //                 console.log(data);
    //                 // if(data['status'] == 'success'){
    //                 //     $(".row_item_"+id).remove();
    //                 //      $("#cart-quantity").text(data['totalCart']);
    //                 // }
    //             },
    //             error: function(err){
    //                 console.log(err);
    //             }
    //     });
    //     });

    

    JS;
$this->registerJs($script);


?>