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
                                    <span class="price"> $<?= $product['price'] ?></span><br>
                                    <span class="price">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">Color :
                                                <input type="hidden" name="product-size" id="product-size" value="S">
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-dark btn-sm rounded-circle"> <?= $product['color'] ?> </span></li>
                                            <li class="list-inline-item">Size :
                                                <input type="hidden" name="product-size" id="product-size" value="S">
                                            </li>
                                            <li class="list-inline-item"><span class="btn btn-dark btn-sm rounded-circle"> <?= $product['size'] ?></span></li>
                                        </ul>
                                    </span>
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
                                                    'class' => 'btn btn-outline-danger btn-sm btn-remove-item warning',
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
            <div class="col-4 rounded h-auto">
                <div class="row ">
                    <div class="card-header border w-100 mb-3">
                        <h2>Price Detail</h2>
                    </div>
                    <div class="card-body border">
                        <h4>Subtotal(<span id="amount-item"><?= $totalCart ?></span>): </h4>
                        <h4><span style="font-size:2.5rem">$</span> <span id='amount-price' style="font-size:2.5rem"><?= $totalPrice ?></span></h4>
                        <hr>
                        <a href="<?= Url::to(['site/checkout']) ?>"><button class="btn btn-primary rounded-0 btn-lg w-100 mt-3">CheckOut</button></a>
                    </div>
                </div><br>
            </div>
        </div>
    </div>
    <div class="row text-left p-2 pb-3 d-flex justify-content-between">
        <h4>Related Products</h4>
        <a class="btn btn-outline-danger btn-md" href="<?= Url::to(['site/add-cart']) ?>"><i class=" fas fa-plus"></i> More</a>
    </div>

    <!--Start Carousel Wrapper-->
    <!-- <div class=" item"> -->
    <div class="owl-carousel owl-theme">
        <?php
        foreach ($products as $key => $model) {
        ?>
            <?php

            // $base_url = Yii::getAlias("@web");
            /*@var \yii\data\ActiveDataProvider $dataProvider*/

            ?>

            <div class="card mb-4 product-wap rounded-0">
                <div class="card rounded-0">
                    <img class="card-img rounded-0 img-fluid image-size" src="<?= $base_url . '/' . $model->image_url ?>" />
                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                        <ul class="list-unstyled">
                            <li>
                                <a class="btn btn-success text-white" href="<?= Url::to('store-single') ?>"><i class="far fa-heart"></i></a>
                            </li>
                            <li>
                                <a class="btn btn-success text-white mt-2" href="<?= Url::to('store-single') ?>"><i class="far fa-eye"></i></a>
                            </li>
                            <li>
                                <a class="btn btn-success text-white mt-2" href="<?= Url::to('store-single') ?>"><i class="fas fa-cart-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <a href="<?= Url::to('store-single') ?>" class="h3 text-decoration-none"><?= $model->status ?></a>
                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                        <li>M/L/X/XL</li>
                        <li class="pt-2">
                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                        </li>
                    </ul>
                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                        <li>
                            <?=

                            $star_str = '';
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $model->rate) {
                                    echo ' <i class="text-warning fa fa-star"></i>';
                                } else {
                                    echo ' <i class="fas fa-star"></i>';
                                }
                            }

                            ?>
                        </li>
                    </ul>
                    <p class="text-center mb-0">$<?= $model->price ?></p>
                </div>
            </div>
        <?php
        }

        ?>
        <!-- </div> -->
    </div>
</div>

<?php
$change_quantity_url = Url::to(['site/change-quantity']);

$script = <<< JS
        const change_quantity_url = "$base_url";
        
        // input spinner
         var owl = $('.owl-carousel')
            owl.owlCarousel({
            loop:true,
            stagePadding: 50,
            autoplay:true,
            autoplayTimeout:3000,
            margin:10,
            navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false
                }
            }
        });

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
            let timerInterval
                Swal.fire({
                title: 'Deleting!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 500,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
                })
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