<?php

namespace frontend\controllers;

use Yii;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $order_id
     * @param integer $material_id
     * @param string $name
     * @return mixed
     */
    public function actionView($order_id, $material_id, $name)
    {
        return $this->render('view', [
            'model' => $this->findModel($order_id, $material_id, $name),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $order_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAdd($order_id)
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->order_id = $order_id;
            if ($model->save()) {
                return $this->redirect(['order/view', 'id' => $order_id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $order_id
     * @param integer $material_id
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($order_id, $material_id, $name)
    {
        $model = $this->findModel($order_id, $material_id, $name);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['order/view', 'id' => $order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $order_id
     * @param integer $material_id
     * @param string $name
     * @return mixed
     */
    public function actionDelete($order_id, $material_id, $name)
    {
        $this->findModel($order_id, $material_id, $name)->delete();

        return $this->redirect(['order/view', 'id' => $order_id]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $order_id
     * @param integer $material_id
     * @param string $name
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($order_id, $material_id, $name)
    {
        if (($model = Product::findOne(['order_id' => $order_id, 'material_id' => $material_id, 'name' => $name])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
