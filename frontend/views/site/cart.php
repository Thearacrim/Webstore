<?php
$base_url = Yii::getAlias("@web");

?>

<div class="container">
    <div class="cart-main">
        <h2>Items</h2>
        <div class="row">
            <div class="col-8">

                <?php foreach ($relatedProduct as $key => $product) { ?>
                    <hr>
                    <div class="row">
                        <div class="col-2">
                            <img src="<?= $base_url . '/' . $product->image_url ?>" style="width:100px">
                        </div>
                        <div class="col-7">
                            <span class="status"> <?= $product->status ?>
                            </span><br>
                            <span class="price"> $<?= $product->price ?></span><br><br>
                            <button class="btn btn-primary btn-sm">Save Later</button>
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </div>
                        <div class="col-3 center d-inline py-5">
                            <input class="form-control " type="number" min='0' style="width:60px">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-4 puchesh">
                <h4>Price Detail</h4>
                <hr>
                <div class="row">
                    <div class="col-6">
                        Price(Item)
                        <br>
                        Delivery Charges
                    </div>
                    <div class="col-6">
                        $
                        <br>
                        Free
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        Amount Payable
                    </div>
                    <div class="col-6">
                        $
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