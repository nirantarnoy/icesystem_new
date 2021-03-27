<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

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
                'rules' => [
//                    [
//                        'actions' => ['captcha'],
//                        'allow' => false,
//                    ],
                    [
                        'actions' => ['login', 'error', 'createadmin', 'changepassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','mas'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
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
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $f_date = null;
        $t_date = null;

        $dash_board = \Yii::$app->request->post('dashboard_date');
        $x_date = explode('-', trim($dash_board));
        if($x_date != null){
            if (count($x_date) > 1) {
                $ff_date = $x_date[0];
                $tt_date = $x_date[1];

                $fff_date = explode('/', trim($ff_date));
                if (count($fff_date) > 0) {
                    $f_date = $fff_date[2] . '-' . $fff_date[1] . '-' . $fff_date[0];
                }
                $ttt_date = explode('/', trim($tt_date));
                if (count($ttt_date) > 0) {
                    $t_date = $ttt_date[2]. '-' . $ttt_date[1] . '-' . $ttt_date[0];
                }
            }
        }

//        echo $f_date.' and '.$t_date;return;

        $prod_cnt = \backend\models\Product::find()->count();
        $route_cnt = \backend\models\Deliveryroute::find()->count();
        $car_cnt = \backend\models\Car::find()->count();
        $order_cnt = \backend\models\Orders::find()->count();
        $order_pos_cnt = \backend\models\Orders::find()->where(['sale_channel_id' => 2])->count();
        $order_normal_cnt = \backend\models\Orders::find()->where(['sale_channel_id' => 1])->count();
        $order_lastest = \common\models\QuerySaleLastest::find()->all();


//        $sql = "select sale_channel_type,sum(m1) as m1 ,sum(m2) as m2,sum(m3) as m3,sum(m4) as m4,sum(m5) as m5,sum(m6) as m6,sum(m7) as m7,sum(m8) as m8,sum(m9) as m9,sum(m10) as m10,sum(m11) as m11,sum(m12) as m12 from query_sale_amount_by_sale_type";
//        if ($f_date != null && $t_date != null) {
//            $sql .= " where date(order_date) >='" . date('Y-m-d', strtotime($f_date)) . "' and date(order_date) <='" . date('Y-m-d', strtotime($t_date))."'";
//        }
//        $sql.=" group by sale_channel_type";
////echo $sql;return;
//        $query = \Yii::$app->db->createCommand($sql)->queryAll();
//        $category = ['มค.', 'กพ.', 'มีค.', 'เมษ.', 'พค.', 'มิย.', 'กค', 'สค', 'กย', 'ตค', 'พย', 'ธค'];
//        $data_by_type = [];
//        for ($i = 0; $i <= count($query) - 1; $i++) {
//            array_push($data_by_type, [
//                //  'type' => 'column',
//                'name' => $query[$i]['sale_channel_type'],
//                'data' => [
//                    ($query[$i]['m1'] * 1), ($query[$i]['m2'] * 1), ($query[$i]['m3'] * 1), ($query[$i]['m4'] * 1),
//                    ($query[$i]['m5'] * 1), ($query[$i]['m6'] * 1), ($query[$i]['m7'] * 1), ($query[$i]['m8'] * 1),
//                    ($query[$i]['m9'] * 1), ($query[$i]['m10'] * 1), ($query[$i]['m11'] * 1), ($query[$i]['m12'] * 1)
//                ]
//            ]);
//        }
//
//        $sql2 = "select code,name,sum(total_amount) as total_amount from query_sale_amount_by_product WHERE total_amount > 0";
//        if ($f_date != null && $t_date != null) {
//            $sql2 .= " AND date(order_date) >='" . date('Y-m-d', strtotime($f_date)) . "' and date(order_date) <='" . date('Y-m-d', strtotime($t_date))."'";
//        }
//        $sql2.=" group by code";
////        echo $sql2;
////        return;
//        $query2 = \Yii::$app->db->createCommand($sql2)->queryAll();
//        $data_by_prod_type = [];
//        $data_prod_data = [];
//        for ($i = 0; $i <= count($query2) - 1; $i++) {
//            array_push($data_prod_data, [
//                'name' => $query2[$i]['name'],
//                'y' => (float)$query2[$i]['total_amount'],
//                'selected' => false
//            ]);
//
//        }
//
//        array_push($data_by_prod_type, [
//                'name' => 'ยอดขาย',
//                'data' => $data_prod_data
//            ]
//        );
//        ['name' => 'Test',
//            'data' => [
//                ['name' => 'Chrome',
//                    'y' => 60.0,
//                    'selected' => true,],
//                ['name' => 'IE',
//                    'y' => 69.0,
//                    'selected' => false,]
//            ]
//        ]

        return $this->render('index', [
            'prod_cnt' => $prod_cnt,
            'route_cnt' => $route_cnt,
            'car_cnt' => $car_cnt,
            'order_cnt' => $order_cnt,
            'order_pos_cnt' => $order_pos_cnt,
            'order_normal_cnt' => $order_normal_cnt,
//            'data_by_type' => $data_by_type,
//            'data_by_prod_type' => $data_by_prod_type,
//            'category' => $category,
            'f_date' => $f_date,
            't_date' => $t_date,
            'order_lastest' => $order_lastest,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            $this->layout = 'main_login';
            $model->password = '';
            return $this->render('login_new', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionChangepassword()
    {
        $model = new \backend\models\Resetform();
        if ($model->load(Yii::$app->request->post())) {

            $model_user = \backend\models\User::find()->where(['id' => Yii::$app->user->id])->one();
            if ($model->oldpw != '' && $model->newpw != '' && $model->confirmpw != '') {
                if ($model->confirmpw != $model->newpw) {
                    $session = Yii::$app->session;
                    $session->setFlash('msg_err', 'รหัสยืนยันไม่ตรงกับรหัสใหม่');
                } else {
                    if ($model_user->validatePassword($model->oldpw)) {
                        $model_user->setPassword($model->confirmpw);
                        if ($model_user->save()) {
                            $session = Yii::$app->session;
                            $session->setFlash('msg_success', 'ทำการเปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
                            return $this->redirect(['site_/logout']);
                        }
                    } else {
                        $session = Yii::$app->session;
                        $session->setFlash('msg_err', 'รหัสผ่านเดิมไม่ถูกต้อง');
                    }
                }

            } else {
                $session = Yii::$app->session;
                $session->setFlash('msg_err', 'กรุณาป้อนข้อมูลให้ครบ');
            }

        }
        return $this->render('_setpassword', [
            'model' => $model
        ]);
    }

    public function actionForgetpassword()
    {

    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $is_sendmail = $this->sendReset($model->email);
            //if ($model->sendEmail()) {
            if ($is_sendmail) {
                Yii::$app->session->setFlash('success', 'ตรวจสอบข้อความและดำเนินการต่อที่ Inbox Email ของคุณต่อได้เลย.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'พบข้อผิดพลาด, ทางเราไม่สามารถส่งข้อมูลไปยัง Email ที่ระบุ.');
            }
        }

        $this->layout = 'main_page';

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function sendReset($email)
    {
        $is_send = 0;

        $user = \common\models\User::findOne([
            'status' => \common\models\User::STATUS_ACTIVE,
            'email' => $email,
        ]);

        if (!$user) {
            return false;
        }

        if (!\common\models\User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        $token = $user->password_reset_token;

        $mesg = 'สวัสดี คุณ' . 'test' . '<br />';
        $mesg = $mesg . 'คุณสามารถดำเนินการเปลี่ยนรหัสผ่านได้ที่ Link ด้านล่างนี้ ' . '<br />';
        $mesg = $mesg . '<p><a href="https://www.ngansorn.com/tutor/site_/reset-password/token/' . $token . '">เปลี่ยนรหัสผ่าน</a> </p>';


        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->isHTML(true);

        /* ------------------------------------------------------------------------------------------------------------- */
        /* ตั้งค่าการส่งอีเมล์ โดยใช้ SMTP ของ Gmail */
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "TLS";                 // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
        $mail->Port = 587;                   // set the SMTP port for the GMAIL server
        $mail->Username = "ngansorntutor@gmail.com";  // Gmail Email username ngansorntutor@gmail.com ngansorn98168
        $mail->Password = "tpmcaakvxdibfxwq";            // App Password not Gmail password
        /* ------------------------------------------------------------------------------------------------------------- */

        $mail->setFrom('ngansorntutor@gmail.com', 'Ngansorn.com');
        $mail->AddAddress($email);
        $mail->AddReplyTo('system');
        $mail->Subject = 'ดำเนินการเปลี่ยนรหัสผ่าน';
        $mail->Body = $mesg;
        $mail->WordWrap = 50;
//
        if ($mail->Send()) {
            $is_send = 1;
        }
        return $is_send;

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
            Yii::$app->session->setFlash('success', 'รหัสผ่านของคุณได้เปลี่ยนเรียบร้อยแล้ว.');

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
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
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

    public function actionCreateadmin()
    {
        $model = new \common\models\User();
        $model->username = 'iceadmin';
        $model->setPassword('123456');
        $model->generateAuthKey();
        $model->email = 'admin@icesystem.com';
        if ($model->save()) {
            \Yii::$app->session->set('login_worker', $model->username);
            echo "ok";
        }

    }

    public function actionApiLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return ['status' => false, 'data' => 'Not permission'];
        }

        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $attributes = \Yii::$app->request->post();
        $model = new LoginForm();
        $model->username = $attributes['username'];
        $model->password = $attributes['password'];
        if ($model->login()) {
            return ['status' => true, 'data' => 'login successfully'];
        } else {
            return ['status' => false, 'data' => 'login fail'];
        }
//        $member = \common\models\Member::find()->where(['id'=>$attributes['id']])->one();
//
//        if($member){
//            $member->attributes = \Yii::$app->request->post();
//            $member->save();
//            return ['status'=> true,'data'=>'Record is updated'];
//        }else{
//            return ['status'=> false,'data'=>$member->getErrors()];
//        }
    }
}
