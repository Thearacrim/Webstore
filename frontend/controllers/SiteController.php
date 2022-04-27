<?php

namespace frontend\controllers;

use backend\models\Banner;
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
use frontend\models\ProductSearch;
use frontend\models\SaveLater;
use frontend\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $shoes = Product::find()->where(['type_item' => '6'])->one();
        $watch = Product::find()->where(['type_item' => '5'])->one();
        $glasses = Product::find()->where(['type_item' => '3'])->one();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'shoes' => $shoes,
            'glasses' => $glasses,
            'watch' => $watch
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

        return $this->renderAjax('login', [
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
            if ($model->sendEmail(Yii::$app->params['Verify'])) {
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
            } else if ($this->request->post('action') == 'save_for_later') {
                $id = $this->request->post('id');
                $save_id = $this->request->post('save_id');
                $current_user = Yii::$app->user->identity->id;
                $save_later = SaveLater::find()->where(['user_id' => $current_user, 'product_id' => $save_id])->one();
                if (Cart::findOne($id)->delete()) {
                    $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $current_user])->one();
                    $totalCart = $totalCart->quantity;
                    $totalPrice_in_de_remove = Yii::$app->db->createCommand("SELECT 
                        SUM(cart.quantity * product.price) as total_price
                        FROM cart
                        INNER JOIN product ON product.id = cart.product_id
                        WHERE user_id = :userId
                    ")
                        ->bindParam("userId", $current_user)
                        ->queryScalar();
                    if (!$save_later) {
                        $save_later = new SaveLater();
                        $save_later->product_id = $save_id;
                        $save_later->user_id = $current_user;
                    }
                    if ($save_later->save()) {
                        $product_save_later = Yii::$app->db->createCommand(
                            "SELECT product.id as id, product.status as status, product.price as price, product.image_url as image_url,save_later.user_id as user_id FROM `product`
                            INNER JOIN save_later ON save_later.product_id = product.id
                            WHERE user_id = :user_id
                            "
                        )
                            ->bindParam("user_id", $current_user)
                            ->queryAll();
                        $result = [];
                        foreach ($product_save_later as $product_save) {
                            $result[] = [
                                'id' => $product_save['id'],
                                'url' => $product_save['image_url'],
                                'status' => $product_save['status'],
                                'price' => $product_save['price']
                            ];
                        }
                        return json_encode([
                            'status' => 'success',
                            'totalPrice_in_de_remove' => $totalPrice_in_de_remove,
                            'product_save_later' => $result,
                            'totalCart' => $totalCart,
                        ]);
                    }
                }
            } else if ($this->request->post('action') == 'move-to-cart') {
                $id = $this->request->post('save_id');
                if (SaveLater::find()->where(['product_id' => $id])->one()->delete()) {
                    return json_encode(['status' => 'success']);
                }
            }
        }

        $userId = Yii::$app->user->id;
        $relatedProduct = Yii::$app->db->createCommand(
            "SELECT product.*,cart.color_id, cart.size_id, cart.quantity, cart.id AS cart_id, variant_size.size, variant_color.color  FROM cart
            INNER JOIN product ON product.id = cart.product_id
            INNER JOIN variant_size ON variant_size.id = cart.size_id
            INNER JOIN variant_color ON variant_color.id = cart.color_id
            WHERE cart.user_id = :userId "
        )
            ->bindParam('userId', $userId)
            ->queryAll();
        $product_save_later = Yii::$app->db->createCommand(
            "SELECT product.* FROM save_later
            INNER JOIN product ON product.id = save_later.product_id
            WHERE save_later.user_id = :userId "
        )
            ->bindParam('userId', $userId)
            ->queryAll();
        $current_user = Yii::$app->user->id;
        $totalCart = Cart::find()->select(['user_id'])->where(['user_id' => $current_user])->count();
        $totalPrice = Yii::$app->db->createCommand("SELECT 
                SUM(cart.quantity * product.price) as total_price
                FROM cart
                INNER JOIN product ON product.id = cart.product_id
                WHERE cart.user_id = :userId
            ")
            ->bindParam("userId", $userId)
            ->queryScalar();
        $products = Product::find()->all();
        return $this->render(
            'cart',
            [
                'relatedProduct' => $relatedProduct,
                'products' => $products,
                'totalPrice' => $totalPrice,
                'totalCart' => $totalCart,
                'product_save_later' => $product_save_later
            ]
        );
    }

    public function actionSearch()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('stores/store-result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAddCart()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                return $this->render(['site/login']);
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
        $model = Product::find()->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('stores/store', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStoreWatch()
    {
        // if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
        //     if (Yii::$app->user->isGuest) {
        //         return $this->redirect(['site/login']);
        //     }

        //     $id = $this->request->post('id');
        //     $userId = Yii::$app->user->id;
        //     $cart = Cart::find()->where(['product_id' => $id, 'user_id' => $userId])->one();
        //     if ($cart) {
        //         $cart->quantity++;
        //     } else {
        //         $cart = new Cart();
        //         $cart->user_id = $userId;
        //         $cart->product_id = $id;
        //         $cart->quantity = 1;
        //     }
        //     if ($cart->save()) {
        //         $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $userId])->one();
        //         $totalCart = $totalCart->quantity;
        //         return json_encode(['status' => 'success', 'totalCart' => $totalCart]);
        //     } else {
        //         return json_encode(['status' => 'error', 'message' => "something went wrong."]);;
        //     }

        //     return json_encode(['success' => true]);
        // }
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['type_item' => 5]),
            'pagination' => [
                'pageSize' => 9
            ]
        ]);

        return $this->render('stores/store-watch', [
            'dataProvider' => $dataProvider,
        ]);

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStoreMan()
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
            'query' => Product::find()->where(['type_item' => 2]),
            'pagination' => [
                'pageSize' => 9
            ]
        ]);

        return $this->render('stores/store-man', [
            'dataProvider' => $dataProvider,
        ]);

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStoreWomen()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update profile');
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
            'query' => Product::find()->where(['type_item' => 1]),
            'pagination' => [
                'pageSize' => 9
            ]
        ]);

        return $this->render('stores/store-women', [
            'dataProvider' => $dataProvider,
        ]);

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStoreGlasses()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['type_item' => 3]),
            'pagination' => [
                'pageSize' => 9
            ]
        ]);
        return $this->render('stores/store-glasses', [
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionStoreShoes()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['type_item' => 6]),
            'pagination' => [
                'pageSize' => 9
            ]
        ]);
        return $this->render('stores/store-shoes', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionStoreSingle($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);
        $products = Product::find()->where(['id' => $id])->one();

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($this->request->post('action') == 'btn-add-to-cart') {
                if (Yii::$app->user->isGuest) {
                    return $this->render(['site/login']);
                }
                $colorId = $this->request->post('colorId');
                $sizeId = $this->request->post('sizeId');
                $id = $this->request->post('id');
                $userId = Yii::$app->user->id;
                $cart = Cart::find()->where(['product_id' => $id, 'user_id' => $userId, 'color_id' => $colorId, 'size_id' => $sizeId])->one();
                if ($cart) {
                    $cart->quantity++;
                } else {
                    $cart = new Cart();
                    $cart->user_id = $userId;
                    $cart->product_id = $id;
                    $cart->quantity = 1;
                    $cart->size_id = $sizeId;
                    $cart->color_id = $colorId;
                }
                if ($cart->save()) {
                    $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $userId])->one();
                    $totalCart = $totalCart->quantity;
                    return json_encode(['status' => 'success', 'totalCart' => $totalCart]);
                } else {
                    return json_encode(['status' => 'error', 'message' => "something went wrong."]);;
                }

                return json_encode(['success' => true]);
            } else if ($this->request->post('action') == 'btn-buy-now') {
                if (Yii::$app->user->isGuest) {
                    return $this->render(['site/login']);
                }
                $colorId = $this->request->post('colorId');
                $sizeId = $this->request->post('sizeId');
                $id = $this->request->post('id');
                $userId = Yii::$app->user->id;
                $cart = Cart::find()->where(['product_id' => $id, 'user_id' => $userId, 'color_id' => $colorId, 'size_id' => $sizeId])->one();
                if ($cart) {
                    $cart->quantity++;
                } else {
                    $cart = new Cart();
                    $cart->user_id = $userId;
                    $cart->product_id = $id;
                    $cart->quantity = 1;
                    $cart->size_id = $sizeId;
                    $cart->color_id = $colorId;
                }
                if ($cart->save()) {
                    $totalCart = Cart::find()->select(['SUM(quantity) quantity'])->where(['user_id' => $userId])->one();
                    $totalCart = $totalCart->quantity;
                    return $this->redirect(['site/checkout']);
                } else {
                    return json_encode(['status' => 'error', 'message' => "something went wrong."]);;
                }

                return json_encode(['success' => true]);
            }
        }
        $relatedProduct = Product::find()->all();
        return $this->render('stores/store-single', [
            'dataProvider' => $dataProvider,
            'relatedProduct' => $relatedProduct,
            'products' => $products
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSign()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->renderAjax('signup', [
            'model' => $model,
        ]);
    }

    public function actionCheckout()
    {
        // $this->layout = 'header-sec';
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
                "SELECT product.*,cart.color_id, cart.size_id, cart.quantity, cart.id AS cart_id, variant_size.size, variant_color.color  FROM cart
            INNER JOIN product ON product.id = cart.product_id
            INNER JOIN variant_size ON variant_size.id = cart.size_id
            INNER JOIN variant_color ON variant_color.id = cart.color_id
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
            $product = Yii::$app->db->createCommand("SELECT 
                product.price as sub_total
                FROM cart
                INNER JOIN product ON product.id = cart.product_id
                WHERE product.id = cart.product_id
            ")
                ->queryOne();

            if (!$customer) {
                $customer = new Customer();
                $customer->name = $profile;
                $customer->address = Yii::$app->user->identity->email;
                $customer->save();
            }
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->sub_total = $product['sub_total'];
            $order->created_date = date('Y-m-d H:i:s');
            $order->created_by = Yii::$app->user->identity->id;
            if ($order->save()) {
                $order_item_values = [];
                foreach ($carts as $cart) {
                    array_push($order_item_values, [$order->id, $cart->product_id, $cart->color_id, $cart->size_id, $cart->quantity, $cart->product->price, $cart->product->price * $cart->quantity]);
                }
                $query = Yii::$app->db->createCommand()->batchInsert(
                    'order_item',
                    ['order_id', 'product_id', 'color', 'size', 'qty', 'price', 'total'],
                    $order_item_values
                );
                if ($query->execute()) {
                    Cart::deleteAll(['id' => ArrayHelper::getColumn($carts, 'id')]);
                    return $this->redirect(['site/success']);
                }
            }
        }
    }

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
            $imagename = Inflector::slug($model->status) . '-' . time();
            $model->image_url = UploadedFile::getInstance($model, 'image_url');
            $upload_path = ("profile/uploads/");
            if (!empty($model->image_url)) {
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                $model->image_url->saveAs($upload_path . $imagename . '.' . $model->image_url->extension);
                //save file uploaded to db
                $model->image_url = $imagename . '.' . $model->image_url->extension;
            }
            $userId = Yii::$app->user->id;
            // if ($model->image_url == null) {
            //     Yii::$app->session->setFlash('alert', 'Profile user must edit some changed');
            // } else {
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
