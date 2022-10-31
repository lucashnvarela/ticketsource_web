<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'block', 'unblock', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $db_users = User::find()
            ->where(['not', ['username' => 'admin']])
            ->orderBy('created_at DESC')
            ->all();

        return $this->render('index', [
            'db_users' => $db_users,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @brief Blocks a user
     * 
     * @param int $id
     */
    public function actionBlock($id) {

        if (Yii::$app->user->can('bloquearCliente')) $this->findModel($id)->block();
        else Yii::$app->session->setFlash('error', 'Não tem permissões para bloquear');

        return $this->redirect(['index']);
    }

    /**
     * @brief Unblocks a user
     * 
     * @param int $id
     */
    public function actionUnblock($id) {

        if (Yii::$app->user->can('desbloquearCliente')) $this->findModel($id)->unblock();
        else Yii::$app->session->setFlash('error', 'Não tem permissões para desbloquear');

        return $this->redirect(['index']);
    }

    /**
     * @brief Deletes a user
     * 
     * @param int $id
     */
    public function actionDelete($id) {

        //* Alterar permissão para 'eliminarCliente'
        if (Yii::$app->user->can('desbloquearCliente')) $this->findModel($id)->delete();
        else Yii::$app->session->setFlash('error', 'Não tem permissões para eliminar');

        return $this->redirect(['index']);
    }
}
