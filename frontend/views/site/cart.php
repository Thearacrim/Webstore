<?php

use backend\models\Cart;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$base_url = Yii::getAlias("@web");
// $totalCart = Cart::find()->count();

?>

<div class="container">
    <div class="cart-main">
        <div class="row">
            <div class="col-8">
                <div class="card-header">
                    <h2>Items</h2>
                </div>
                <div class="card-body">
                    <!-- <span id="amount-item" style=" font-weight:700;font-size:1.2rem"><?php
                                                                                            if ($totalCart > 1) {
                                                                                                echo $totalCart . " </span>Items in Cart";
                                                                                            } else {
                                                                                                echo $totalCart . " </span>Item in Cart";
                                                                                            } ?> -->
                    <?php foreach ($relatedProduct as $key => $product) { ?>
                        <div class="sec-border row_item_<?= $product['cart_id'] ?> rounded-0 hover p-3">
                            <div class="row ">
                                <div class="col-2">
                                    <img src="<?= $base_url . '/' . $product['image_url'] ?>" style="width:100px">
                                </div>
                                <div class="col-7">
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

                <?php if ($totalPrice == 0) {
                    echo "";
                } else {
                    echo "<h4 id='totalprice' class='float-right'>Subtotal:$ " . $totalPrice;
                }  ?></h4>

            </div>
            <div class="col-4 card rounded ">
                <div class="row ">
                    <div class="card-header w-100 mb-3">
                        <h4>Price Detail</h4>
                    </div>
                    <div class="card-body">
                        <h4>Subtotal(<span id="amount-item"><?= $totalCart ?></span>): <span id='amount-price'>$<?= $totalPrice ?></span></h4>
                        <button class="btn btn-primary rounded-0 btn-lg w-100 mt-3">CheckOut</button>
                    </div>
                </div><br>
                <hr>
                <h4>Payment</h4>
                <div class="row pt-3">
                    <div class="col-4">
                        <a href="#">
                            <img style="width:80px" src="https://is4-ssl.mzstatic.com/image/thumb/Purple115/v4/4a/b7/d9/4ab7d9ea-8e6f-786f-2be0-7ef4afc187be/source/512x512bb.jpg" alt=""></a>
                    </div>
                    <div class="col-4">
                        <a href="#"></a>
                        <img style="width:80px" src="https://apprecs.org/gp/images/app-icons/300/26/com.paygo24.ibank.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="#">
                            <img style="width:80px" src="https://telr.com/sa-en/wp-content/uploads/sites/9/2018/04/visa-w.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <img src="" alt="">
                    </div>
                    <div class="col-4">
                        <img src="" alt="">
                    </div>
                    <div class="col-4">
                        <img src="" alt="">
                    </div>
                </div>
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