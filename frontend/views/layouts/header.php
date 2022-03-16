<?php

use backend\models\Cart;
use yii\base\Model;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

$base_url = Yii::getAlias("@web");


if (\Yii::$app->user->isGuest) {
  $totalCart = 0;
  // $totalCart = $totalCart->quantity;
} else {
  $userId = Yii::$app->user->id;
  $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $userId])->one();
  $totalCart = $totalCart->quantity;
}
?>
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
  <div class="container d-flex justify-content-between align-items-center">

    <a class="navbar-brand text-success logo h1 align-self-center" href="<?= Url::to(['/site']) ?>">
      Zay
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
      <div class="flex-fill">
        <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['/site']) ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['site/about']) ?>">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['site/add-cart']) ?>">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= Url::to(['site/contact']) ?>">Contact</a>
          </li>
        </ul>
      </div>
      <div class="navbar align-self-center d-flex">
        <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
          <div class="input-group">
            <input type="text" class="form-control" id="inputMobileSearch" placeholder="Search ...">
            <div class="input-group-text">
              <i class="fa fa-fw fa-search"></i>
            </div>
          </div>
        </div>
        <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
          <i class="fa fa-fw fa-search text-dark mr-2"></i>
        </a>
        <?php
        if (Yii::$app->user->isGuest) {
        ?>
          <a class="nav-icon position-relative text-decoration-none trigggerModal" value="<?= Url::to(['/site/login']) ?>" href="#">
            <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
            <span id="cart-quantity" class="position-absolute top-0 left-100 translate-middle badge rounded-pill badge badge-danger"><?= $totalCart ?></span>
          </a>
        <?php
        } else {
        ?>
          <a class="nav-icon position-relative text-decoration-none" href="<?= Url::to(['site/cart']) ?>">
            <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
            <span id="cart-quantity" class="position-absolute top-0 left-100 translate-middle badge rounded-pill badge badge-danger"><?= $totalCart ?></span>
          </a>
        <?php
        }
        ?>
        <?php
        if (Yii::$app->user->isGuest) {
        ?>
          <!-- $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'], 'options' => ['class' => 'trigggerModal']]; -->
          <a value="<?= Url::to(['/site/login']) ?>" class="pl-3 trigggerModal">Login <i class="fas fa-sign-in-alt"></i></a>
          <span class="text-dark p-3 fw-bold">|</span>
          <a value="<?= Url::to(['/site/logout']) ?>" class="trigggerModal">Sign Up<i class="fas fa-sign-up-alt"></i></a>

          <!-- $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']]; -->
        <?php
        } else {
        ?>
          <!-- // $menuItems[] = [
          // 'label' => '',
          // 'dropDownOptions' => [
          // 'class' => 'dropdown-menu-right'
          // ],
          // 'items' => [
          // 'layout' => "
          // <a href=" . $base_url . '/site/profile' . " class=''><img class='img-profile d-inline ml-3 rounded-circle' src='https:/media.istockphoto.com/photos/young-man-wearing-headset-and-play-computer-video-games-online-home-picture-id1290727524?b=1&k=20&m=1290727524&s=170667a&w=0&h=8Ff68TwSesdnGUfE_GbVq5-9l-94vga7F0lAZOK8YkQ=' alt=''></a>
          // <div class='d-inline'>
            // <a href=" . $base_url . '/site/profile' . " class=''>" . Yii::$app->user->identity->username . "</a>
            // <span class='email'>" . Yii::$app->user->identity->email . "</span>
            // </div>
          //
          <hr>
          // ",
          // [

          // 'url' => ['/site/logout'],
          // 'linkOptions' => [
          // 'data-method' => 'post'
          // ],
          // 'label' => 'Logout',
          // ]
          // ]
          // ]; -->
          <?php $menuItems[] = ['label' => '',]; ?>
          <div class="btn-group pl-3">
            <div class="dropdown">
              <a class="dropdown-toggle" href="#" id="dropdownMenuButton" data-toggle="dropdown" data-bs-toggle="dropdown" data-bs-display="static" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle" src="https://z-p3-scontent.fpnh5-4.fna.fbcdn.net/v/t1.6435-9/120140539_698945037637217_7884832137117687172_n.jpg?_nc_cat=100&ccb=1-5&_nc_sid=174925&_nc_eui2=AeERhXG-xprtmYzhylEYJBZ2xkMJ97eQBs3GQwn3t5AGzcsSFJeI_NBNcJX-H7G2L6lNBp6o0IJQhiuXXs3NB_sc&_nc_ohc=40H8Cp2GCP4AX9oThbO&_nc_ht=z-p3-scontent.fpnh5-4.fna&oh=00_AT8okI6RuCFN-09J-VF2dKcQnmMs0irr4FhAKlK0UkqQ2Q&oe=625046C5" style="width:40px;height:40px" alt="profile">
              </a>
              <!-- <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                Right-aligned but left aligned when large screen
              </button> -->
              <div class=" dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item d-flex justify-content-between" href="<?= Url::to(['site/profile']) ?>">
                  <img class="rounded-circle mr-3" src="https://z-p3-scontent.fpnh5-4.fna.fbcdn.net/v/t1.6435-9/120140539_698945037637217_7884832137117687172_n.jpg?_nc_cat=100&ccb=1-5&_nc_sid=174925&_nc_eui2=AeERhXG-xprtmYzhylEYJBZ2xkMJ97eQBs3GQwn3t5AGzcsSFJeI_NBNcJX-H7G2L6lNBp6o0IJQhiuXXs3NB_sc&_nc_ohc=40H8Cp2GCP4AX9oThbO&_nc_ht=z-p3-scontent.fpnh5-4.fna&oh=00_AT8okI6RuCFN-09J-VF2dKcQnmMs0irr4FhAKlK0UkqQ2Q&oe=625046C5" style="width:60px;height:60px;object-fit: cover;" alt="profile">
                  <div>
                    <span style="font-size:1.3rem" class="fw-bold"><?= Yii::$app->user->identity->username ?></span><br>
                    <span style="font-size:0.8rem" class="fw-bold"><?= Yii::$app->user->identity->email ?></span>
                  </div>
                </a>
                <hr class="dropdown-divider">
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Cart</a>
                <a class="dropdown-item" href="#">New Order</a>
                <a class="dropdown-item" href="#">Payment</a>
                <hr class="dropdown-divider">
                <a class="dropdown-item" href="<?php Url::to(['site/help']) ?>">Help</a>
                <?= Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post'], 'class' => 'dropdown-item']) ?>
              </div>
            </div>
          </div>
        <?php
        }
        // echo Nav::widget([
        //   'options' => ['class' => 'navbar-nav'],
        //   'items' => $menuItems,
        // ]);
        ?>

        <!-- <a class="nav-icon position-relative text-decoration-none" href="#">
          <i class="fa fa-fw fa-user text-dark ml-5"></i>
          Login
        </a>
        <span class="mr-3">/</span>
        <a class="nav-icon position-relative text-decoration-none" href="#">
          Sing up
        </a> -->
      </div>
    </div>

  </div>
</nav>
<!-- Close Header -->
<?php

$script = <<< JS
          $(document).on("click",".trigggerModal",function(){
                  $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));
                  });
          JS;
$this->registerJs($script);

?>