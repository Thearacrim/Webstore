<?php

namespace frontend\controllers;

use backend\models\Cart;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Customer;
use frontend\models\Order;
use frontend\models\OrderItem;
use frontend\models\Product;
use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'home';
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->all(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionChangeQuantity()
    {
        if ($this->request->isAjax) {
            if ($this->request->post('action') == 'item-quantity') {
                $id = $this->request->post('id');
                $type = $this->request->post('type');
                // return $id;
                // exit;
                $current_user = Yii::$app->user->identity->id;
                $cart = Cart::find()->where(['product_id' => $id, 'user_id' => $current_user])
                    ->one();
                if ($cart) {
                    if ($type == 'add') {
                        $cart->quantity++;
                    } else {
                        $cart->quantity--;
                    }


                    if ($cart->save()) {
                        $totalCart = Cart::find()
                            ->select(['SUM(quantity) quantity'])
                            ->where(['user_id' => $current_user])
                            ->one();
                        $totalCart = $totalCart->quantity;
                        $totalPrice_in_de_remove = Yii::$app->db->createCommand("SELECT 
                            SUM(cart.quantity * product.price) as total_price
                            FROM cart
                            INNER JOIN product ON product.id = cart.product_id
                            WHERE user_id = :userId
                        ")
                            ->bindParam("userId", $current_user)
                            ->queryScalar();
                        return json_encode(['status' => 'success', 'totalCart' => $totalCart, 'totalPrice_in_de_remove' => $totalPrice_in_de_remove]);
                    } else {
                        return json_encode(['status' => 'error', 'message' => "something went wrong."]);;
                    }
                }
            }
        }
    }

    public function actionCart()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        // $relatedProduct = Cart::find()
        //     ->select(['product.*', 'cart.*'])
        //     ->leftJoin('product', 'product.id = cart.product_id')
        //     ->asArray()
        //     ->all();
        if ($this->request->isAjax) {
            if ($this->request->post('action') == 'btn_remove_item') {
                $id = $this->request->post('id');
                $current_user = Yii::$app->user->identity->id;
                if (Cart::findOne($id)->delete()) {
                    $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $current_user])->one();
                    $totalCart = $totalCart->quantity;
                    $totalItem = Cart::find()->select(['user_id'])->where(['user_id' => $current_user])->count();
                    $totalPrice_in_de_remove = Yii::$app->db->createCommand("SELECT 
                        SUM(cart.quantity * product.price) as total_price
                        FROM cart
                        INNER JOIN product ON product.id = cart.product_id
                        WHERE user_id = :userId
                    ")
                        ->bindParam("userId", $current_user)
                        ->queryScalar();
                    $available_item = "There are no items available";
                    return json_encode(['status' => 'success', 'totalCart' => $totalCart, 'totalItem' => $totalItem, 'totalPrice_in_de_remove' => $totalPrice_in_de_remove, 'available_item' => $available_item]);
                }
            }
        }

        $userId = Yii::$app->user->id;
        $relatedProduct = Yii::$app->db->createCommand(
            "SELECT product.*, cart.quantity, cart.id AS cart_id FROM cart
            LEFT JOIN product ON product.id = cart.product_id
            WHERE cart.user_id = :userId"
        )
            ->bindParam('userId', $userId)
            ->queryAll();
        $current_user = Yii::$app->user->id;
        $totalCart = Cart::find()->select(['user_id'])->where(['user_id' => $current_user])->count();
        $totalPrice = Yii::$app->db->createCommand("SELECT 
                SUM(cart.quantity * product.price) as total_price
                FROM cart
                INNER JOIN product ON product.id = cart.product_id
                WHERE user_id = :userId
            ")
            ->bindParam("userId", $userId)
            ->queryScalar();
        // echo '<pre>';
        // print_r($totalPrice);
        // exit;
        return $this->render(
            'cart',
            [
                'relatedProduct' => $relatedProduct,
                'totalPrice' => $totalPrice,
                'totalCart' => $totalCart,
            ]
        );
    }

    public function actionAddCart()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                return $this->redirect(['site/login']);
            }

            $id = $this->request->post('id');
            $userId = Yii::$app->user->id;
            $cart = Cart::find()->where(['product_id' => $id, 'user_id' => $userId])->one();
            if ($cart) {
                $cart->quantity++;
            } else {
                $cart = new Cart();
                $cart->user_id = $userId;
                $cart->product_id = $id;
                $cart->quantity = 1;
            }
            if ($cart->save()) {
                $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $userId])->one();
                $totalCart = $totalCart->quantity;
                return json_encode(['status' => 'success', 'totalCart' => $totalCart]);
            } else {
                return json_encode(['status' => 'error', 'message' => "something went wrong."]);;
            }

            return json_encode(['success' => true]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
            'pagination' => [
                'pageSize' => 6
            ]
        ]);

        return $this->render('store', [
            'dataProvider' => $dataProvider,
        ]);

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStoreSingle()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        $relatedProduct = Product::find()->all();
        return $this->render('store-single', [
            'dataProvider' => $dataProvider,
            'relatedProduct' => $relatedProduct
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionCheckout()
    {
        $this->layout = 'header-sec';
        $model = new OrderItem();
        $current_user = Yii::$app->user->id;
        $totalCart = Cart::find()->select(['user_id'])->where(['user_id' => $current_user])->count();
        if ($totalCart) {
            $userId = Yii::$app->user->id;
            $totalPrice = Yii::$app->db->createCommand("SELECT 
                SUM(cart.quantity * product.price) as total_price
                FROM cart
                INNER JOIN product ON product.id = cart.product_id
                WHERE user_id = :userId
            ")
                ->bindParam("userId", $userId)
                ->queryScalar();
            $userId = Yii::$app->user->id;
            $relatedProduct = Yii::$app->db->createCommand(
                "SELECT product.*, cart.quantity, cart.id AS cart_id FROM cart
            LEFT JOIN product ON product.id = cart.product_id
            WHERE cart.user_id = :userId"
            )
                ->bindParam('userId', $userId)
                ->queryAll();
            $totalCart = Cart::find()->select(['user_id'])->where(['user_id' => $current_user])->count();

            return $this->render(
                'checkout',
                [
                    'model' => $model,
                    'totalPrice' => $totalPrice,
                    'totalCart' => $totalCart,
                    'relatedProduct' => $relatedProduct
                ]
            );
        } else {
            throw new NotFoundHttpException('please add some item to your cart.');
        }
    }
    public function actionPayment()
    {
        if ($this->request->isAjax && $this->request->isPost) {
            $userId = Yii::$app->user->id;
            $profile = Yii::$app->user->identity->username;
            $carts = Cart::find()->where(['user_id' => $userId])->all();
            $customer = Customer::find()->where(['name' => $profile])->one();

            if (!$customer) {
                $customer = new Customer();
                $customer->name = $profile;
                $customer->address = Yii::$app->user->identity->email;
                $customer->save();
            }
            $order = new Order();
            $order->customer_id = $customer->id;
            if ($order->save()) {
                $order_item_values = [];
                foreach ($carts as $cart) {
                    array_push($order_item_values, [$order->id, $cart->product_id, $cart->quantity, $cart->product->price, $cart->product->price * $cart->quantity]);
                }
                $query = Yii::$app->db->createCommand()->batchInsert(
                    'order_item',
                    ['order_id', 'product_id', 'qty', 'price', 'total'],
                    $order_item_values
                );
                if ($query->execute()) {
                    Cart::deleteAll(['id' => ArrayHelper::getColumn($carts, 'id')]);
                    return $this->redirect(['site/success']);
                }
            }
        }
    }
    // public function actionBill()
    // {
    //     $this->layout = 'header-sec';
    //     if ($this->request->isAjax) {
    //         if ($this->request->post('action') == 'info_detail') {
    //             $id = $this->request->post('id');
    //             $userId = Yii::$app->user->id;
    //             $totalCart = Cart::find()->select(['quantity'])->where(['user_id' => $userId])->one();
    //             $totalCart = $totalCart->quantity;
    //             $profile = Yii::$app->user->identity->username;
    //             $customer = Customer::find()->where(['name' => $profile])->one();
    //             $customerId = Customer::find()->select(['id'])->where(['name' => $profile])->one();
    //             $orderId = Order::find()->select(['id'])->where(['customer_id' => $customerId])->one();
    //             $orderItem = OrderItem::find()->where(['product_id' => $id, 'order_id' => $orderId])->one();
    //             // return $orderItem;
    //             // exit;
    //             if ($customer) {
    //                 ////
    //                 if ($customerId->id) {
    //                     if ($orderItem) {
    //                         // $orderItem = new OrderItem();
    //                         // $orderItem->order_id = $orderId->id;
    //                         // $orderItem->product_id = $id;
    //                         // $orderItem->qty = $totalCart;
    //                         // $orderItem->save();
    //                         // return 1;
    //                     } else {
    //                         $orderItem = new OrderItem();
    //                         $orderItem->order_id = $orderId->id;
    //                         $orderItem->product_id = $id;
    //                         $orderItem->qty = $totalCart;
    //                         $orderItem->save();
    //                         // return 2;
    //                     }
    //                 } else {
    //                     $order = new Order();
    //                     $order->customer_id = $customerId->id;
    //                     $order->save();
    //                     $orderItem = new OrderItem();
    //                     $orderItem->order_id = $orderId->id;
    //                     $orderItem->product_id = $orderId->id;
    //                     $orderItem->qty = $totalCart;
    //                     $orderItem->save();
    //                     // return 3;
    //                 }
    //             } else {
    //                 $customer = new Customer();
    //                 $customer->name = $profile;
    //                 $customer->address = Yii::$app->user->identity->email;
    //                 $order = new Order();
    //                 $order->customer_id = $customerId->id;
    //                 $order->save();
    //                 $orderItem = new OrderItem();
    //                 $orderItem->order_id = $orderId->id;
    //                 $orderItem->product_id = $id;
    //                 $orderItem->qty = $totalCart;
    //                 $orderItem->save();
    //             }
    //             if ($orderItem->save()) {
    //                 $current_user = Yii::$app->user->id;
    //                 $id_remove = Cart::find()->select(['id'])->where(['user_id' => $current_user])->one();
    //                 if (Cart::findOne($id_remove)->delete()) {
    //                     $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $current_user])->one();
    //                     $totalCart = $totalCart->quantity;
    //                     $totalItem = Cart::find()->select(['user_id'])->where(['user_id' => $current_user])->count();
    //                     $totalPrice_in_de_remove = Yii::$app->db->createCommand("SELECT product.price,
    //                     SUM(cart.quantity * product.price) as total_price
    //                     FROM cart
    //                     INNER JOIN product ON product.id = cart.product_id
    //                     WHERE user_id = :userId
    //                 ")
    //                         ->bindParam("userId", $current_user)
    //                         ->queryScalar();
    //                     return json_encode(['status' => 'success', 'totalCart' => $totalCart, 'totalItem' => $totalItem, 'totalPrice_in_de_remove' => $totalPrice_in_de_remove]);
    //                     return $this->redirect('success');
    //                 }
    //                 return json_encode(['status' => 'success']);
    //             } else {
    //                 return json_encode(['status' => 'error', 'message' => "something went wrong."]);
    //             }

    //             return json_encode(['success' => true]);

    //             return $this->redirect('success');
    //         }
    //     }
    // }

    public function actionSuccess()
    {
        $this->layout = 'header-sec';

        return $this->render('success');
    }



    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $model = User::findOne(Yii::$app->user->id);
        if ($this->request->isPost && $model->load($this->request->post())) {
            $userId = Yii::$app->user->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update profile');
            }
            return $this->redirect(["site/profile"]);
        }
        return $this->render(
            'profile',
            [
                'model' => $model,
            ]
        );
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
