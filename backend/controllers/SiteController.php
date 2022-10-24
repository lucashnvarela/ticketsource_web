<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model_login = new LoginForm();
        if ($model_login->load(Yii::$app->request->post())) {

            $user_login = User::findByUsername($model_login->username);

            if (is_null($user_login))
                Yii::$app->session->setFlash('error', 'Username ou password estão errados');
            elseif ($user_login->validatePassword($model_login->password)) {
                if (Yii::$app->authManager->getAssignment('cliente', $user_login->id) == null) {
                    $model_login->login();

                    return $this->redirect('index');
                } else {
                    Yii::$app->session->setFlash('error', 'Sem permissão de acesso');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Username ou password estão errados');
            }
        }

        $model_login->password = '';

        return $this->render('login', [
            'model_login' => $model_login,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {

        $model_signup = new SignupForm();
        if ($model_signup->load(Yii::$app->request->post()) && $model_signup->signup('gestorBilheteira')) {
            Yii::$app->session->setFlash('success', 'Registo efetuado com sucesso');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model_signup' => $model_signup,
        ]);
    }
}
