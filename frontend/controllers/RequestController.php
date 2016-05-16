<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\RequestedMaterialDetail;
use Yii;
use common\models\RequestedMaterial;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequestController implements the CRUD actions for RequestedMaterial model.
 */
class RequestController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all RequestedMaterial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RequestedMaterial model.
     * @param integer $id
     * @param integer $order_id
     * @return mixed
     */
    public function actionView($id, $order_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $order_id),
        ]);
    }

    /**
     * Creates a new RequestedMaterial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RequestedMaterial();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'order_id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RequestedMaterial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $order_id
     * @return mixed
     */
    public function actionUpdate($id, $order_id)
    {
        $model = new RequestedMaterialDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->requested_material_id, 'order_id' => $model->requestedMaterial->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RequestedMaterial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $order_id
     * @return mixed
     */
    public function actionDelete($id, $order_id)
    {
        $this->findModel($id, $order_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RequestedMaterial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $order_id
     * @return RequestedMaterial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $order_id)
    {
        if (($model = RequestedMaterial::findOne(['id' => $id, 'order_id' => $order_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
