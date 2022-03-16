<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$base_url = Yii::getAlias("@web");

?>
<!-- Open Content -->
<section class="bg-light">
    <div class="container pb-5">
        <div class="row product-item" data-key="<?= $products->id ?>">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="<?= $base_url ?>/<?= $products->image_url ?>" alt="Card image cap" id="product-detail">
                </div>
                <div class="row">
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-dark fas fa-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </div>
                    <!--End Controls-->
                    <!--Start Carousel Wrapper-->
                    <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
                        <!--Start Slides-->
                        <div class="carousel-inner product-links-wap" role="listbox">

                            <!--First slide-->
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_01.jpg" alt="Product Image 1">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_02.jpg" alt="Product Image 2">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_03.jpg" alt="Product Image 3">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/.First slide-->

                            <!--Second slide-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_04.jpg" alt="Product Image 4">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_05.jpg" alt="Product Image 5">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_06.jpg" alt="Product Image 6">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/.Second slide-->

                            <!--Third slide-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_07.jpg" alt="Product Image 7">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_08.jpg" alt="Product Image 8">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= $base_url ?>/template/img/product_single_09.jpg" alt="Product Image 9">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/.Third slide-->
                        </div>
                        <!--End Slides-->
                    </div>
                    <!--End Carousel Wrapper-->
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-dark fas fa-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2"><?= $products->status ?></h1>
                        <p class="h3 py-2">$<?= $products->price ?>.00</p>
                        <p class="py-2">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                        </p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Brand:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>Easy Wear</strong></p>
                            </li>
                        </ul>

                        <h6>Description:</h6>
                        <p><?= $products->description ?></p>
                        <ul class="list-inline pb-3" id="menu-color">
                            <li class="list-inline-item">Available Color :
                            </li>
                            <li class="list-inline-item"><a class="btn btn-success btn-sm btn-size rounded-circle" data-value="1">White</a></li>
                            <li class="list-inline-item"><a class="btn btn-success btn-sm btn-size rounded-circle" data-value="2"> Red </a></li>
                            <!-- <li class="list-inline-item"><span class="btn btn-success btn-size">XL</span></li> -->
                        </ul>
                        <input type="hidden" name="product-size" id="product-color" value="1">

                        <h6>Specification:</h6>
                        <ul class="list-unstyled pb-3">
                            <li>Lorem ipsum dolor sit</li>
                            <li>Amet, consectetur</li>
                            <li>Adipiscing elit,set</li>
                            <li>Duis aute irure</li>
                            <li>Ut enim ad minim</li>
                            <li>Dolore magna aliqua</li>
                            <li>Excepteur sint</li>
                        </ul>

                        <form action="" method="GET">
                            <input type="hidden" name="product-title" value="Activewear">
                            <div class="row">
                                <div class="col-auto">
                                    <ul id="rmenu" role="menu">
                                        <li class="list-inline-item">Size :
                                        </li>
                                        <li class="list-inline-item"><a class="btn btn-success btn-size" data-value="1">S</a></li>
                                        <li class="list-inline-item"><a class="btn btn-success btn-size" data-value="2">M</a></li>
                                        <li class="list-inline-item"><a class="btn btn-success btn-size" data-value="3">L</a></li>
                                        <li class="list-inline-item"><a class="btn btn-success btn-size" data-value="4">XL</a></li>
                                    </ul>
                                    <input type="hidden" name="search_param" value="1" id="search_param">
                                </div>
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Quantity
                                            <input type="hidden" name="product-quanity" id="product-quanity" value="1">
                                        </li>
                                        <li class="list-inline-item"><a class="btn btn-success" id="btn-minus">-</a></li>
                                        <li class="list-inline-item"><a class="badge bg-secondary" id="var-value">1</a></li>
                                        <li class="list-inline-item"><a class="btn btn-success" id="btn-plus">+</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Buy</button>
                                </div>
                                <div class="col d-grid">
                                    <a class="btn btn-success btn-lg btn-add-to-cart" value="<?= Url::to(['/site/login']) ?>">Add To Cart</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Close Content -->

<!-- Start Article -->
<section class=" py-5">
    <div class="container">
        <div class="row text-left p-2 pb-3">
            <h4>Related Products</h4>
        </div>

        <!--Start Carousel Wrapper-->
        <!-- <div class="item"> -->
        <div class="owl-carousel owl-theme">
            <?php
            foreach ($relatedProduct as $key => $model) {
            ?>
                <?php

                $base_url = Yii::getAlias("@web");
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



</section>


<!-- End Article -->

<?php
$add_cart_url = Url::to(['site/store-single?id=' . $model->id]);

$script = <<< JS

        //     $("#menu-size").on("click", function(e){
        //     e.preventDefault();
        //     var this = $(this);
        //     $("#product-size").text(this.data("value"));
        //     $("#product-size").attr('name',this.data("value"));
        // });
            // $('#menu-size').on('click','a',function(){
            //     var val = $(this);
            //     $('#product-size').attr(val.data("value"));
            //     $("#product-size").name(val.data("value"));
            // });
            $(function(){
                $('#rmenu > li > a').click(function(e){
                    e.preventDefault();
                    var val = $(this).attr('data-value');
                    $('#search_param').attr('name', val);
                    $('#search_param').val(val);
                });
            });
            $(function(){
                $('#menu-color > li > a').click(function(e){
                    e.preventDefault();
                    var val = $(this).attr('data-value');
                    $('#product-color').attr('name', val);
                    $('#product-color').val(val);
                });
            });

            var base_url = "$base_url";

            $(".btn-add-to-cart").click(function(e){
                e.preventDefault();
                var id = $(this).closest(".product-item").data("key");
                var colorId = $("#search_param").val();
                var sizeId = $("#product-color").val();
                console.log(sizeId);
                $.ajax({
                    url: '$add_cart_url' ,
                    method: 'POST',
                    data: {
                        id: id,
                        colorId : colorId,
                        sizeId : sizeId
                    },
                    success: function(res){
                        var data = JSON.parse(res);
                        console.log(data);
                        // if(data['status'] == 'success'){
                        //     $("#cart-quantity").text(data['totalCart']);
                        // }else{
                        //     alert(data['message']);
                        // }
                    },
                    error: function(err){
                        console.log(err);
                    }
                });


            });

             var owl = $('.owl-carousel')
            owl.owlCarousel({
            loop:true,
            stagePadding: 50,
            autoplay:true,
            autoplayTimeout:3000,
            margin:10,
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
        })
        JS;
$this->registerJs($script);

?>