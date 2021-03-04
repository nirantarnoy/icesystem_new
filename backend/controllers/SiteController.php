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
                        'actions' => ['login', 'error','createadmin','changepassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
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
        $prod_cnt = \backend\models\Product::find()->count();
        $route_cnt = \backend\models\Deliveryroute::find()->count();
        $car_cnt = \backend\models\Car::find()->count();
        $order_cnt = \backend\models\Orders::find()->count();
        $order_pos_cnt = \backend\models\Orders::find()->where(['sale_channel_id'=>2])->count();
        $order_normal_cnt = \backend\models\Orders::find()->where(['sale_channel_id'=>1])->count();

        return $this->render('index',[
            'prod_cnt' => $prod_cnt,
            'route_cnt' => $route_cnt,
            'car_cnt' => $car_cnt,
            'order_cnt' => $order_cnt,
            'order_pos_cnt' => $order_pos_cnt,
            'order_normal_cnt' => $order_normal_cnt
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

    public function actionChangepassword(){
        $model=new \backend\models\Resetform();
        if($model->load(Yii::$app->request->post())){

            $model_user = \backend\models\User::find()->where(['id'=>Yii::$app->user->id])->one();
            if($model->oldpw != '' && $model->newpw != '' && $model->confirmpw !=''){
                if($model->confirmpw != $model->newpw){
                    $session = Yii::$app->session;
                    $session->setFlash('msg_err','รหัสยืนยันไม่ตรงกับรหัสใหม่');
                }else{
                    if($model_user->validatePassword($model->oldpw)){
                        $model_user->setPassword($model->confirmpw);
                        if($model_user->save()){
                            $session = Yii::$app->session;
                            $session->setFlash('msg_success','ทำการเปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
                            return $this->redirect(['site_/logout']);
                        }
                    }else{
                        $session = Yii::$app->session;
                        $session->setFlash('msg_err','รหัสผ่านเดิมไม่ถูกต้อง');
                    }
                }

            }else{
                $session = Yii::$app->session;
                $session->setFlash('msg_err','กรุณาป้อนข้อมูลให้ครบ');
            }

        }
        return $this->render('_setpassword',[
            'model'=>$model
        ]);
    }
    public function actionForgetpassword(){

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

    public function sendReset($email){
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

        $mesg = 'สวัสดี คุณ'.'test' .'<br />';
        $mesg = $mesg.'คุณสามารถดำเนินการเปลี่ยนรหัสผ่านได้ที่ Link ด้านล่างนี้ '.'<br />';
        $mesg = $mesg.'<p><a href="https://www.ngansorn.com/tutor/site_/reset-password/token/'.$token.'">เปลี่ยนรหัสผ่าน</a> </p>';


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

        $mail->setFrom('ngansorntutor@gmail.com','Ngansorn.com');
        $mail->AddAddress($email);
        $mail->AddReplyTo('system');
        $mail->Subject = 'ดำเนินการเปลี่ยนรหัสผ่าน';
        $mail->Body     = $mesg;
        $mail->WordWrap = 50;
//
        if($mail->Send()) {
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

    public function actionCreateadmin(){
        $model = new \common\models\User();
        $model->username = 'iceadmin';
        $model->setPassword('123456');
        $model->generateAuthKey();
        $model->email = 'admin@icesystem.com';
        if($model->save()){
            \Yii::$app->session->set('login_worker', $model->username);
            echo "ok";
        }

    }

    public function actionApiLogin(){
        if (!Yii::$app->user->isGuest) {
            return ['status'=> false,'data'=>'Not permission'];
        }

        \Yii::$app->response->format = \Yii\web\Response::FORMAT_JSON;
        $attributes = \Yii::$app->request->post();
        $model = new LoginForm();
        $model->username = $attributes['username'];
        $model->password = $attributes['password'];
        if ($model->login()) {
            return ['status'=> true,'data'=>'login successfully'];
        } else {
            return ['status'=> false,'data'=>'login fail'];
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
