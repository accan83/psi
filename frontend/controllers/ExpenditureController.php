<?php

namespace frontend\controllers;

use common\models\Material;
use common\models\MaterialExpenditureDetail;
use common\models\RequestedMaterial;
use common\models\RequestedMaterialDetail;
use Yii;
use common\models\MaterialExpenditure;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExpenditureController implements the CRUD actions for MaterialExpenditure model.
 */
class ExpenditureController extends Controller
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
     * Lists all MaterialExpenditure models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RequestedMaterial::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialExpenditure model.
     * @param integer $id
     * @param $requested_material_id
     * @return mixed
     * @throws NotFoundHttpException
     * @internal param $requested_id
     */
    public function actionView($id, $requested_material_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'requested_material_id' => $requested_material_id,
        ]);
    }

    /**
     * Creates a new MaterialExpenditure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($requested_material_id)
    {
        $model = new MaterialExpenditure();
        $requested = RequestedMaterial::find()->where(['id', $requested_material_id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'requested_material_id' => $requested_material_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'requested' => $requested,
            ]);
        }
    }

    /**
     * Updates an existing MaterialExpenditure model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $material_id)
    {
        $model = new MaterialExpenditureDetail();
        $materialExpenditure = MaterialExpenditure::find()->where(['id' => $id])->one();
        $material = Material::find()->where(['id' => $material_id])->one();
        $requestedMaterial = RequestedMaterialDetail::find()->where(['requested_material_id' => $materialExpenditure->requested_material_id, 'material_id' => $material->id])->one();

        if ($model->load(Yii::$app->request->post())) {
            $stock = $material->stock->qty;
            $safetyStock = $material->safety_stock;
            if ($stock - $model->qty >= $safetyStock) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $materialExpenditure->id, 'requested_material_id' => $materialExpenditure->requested_material_id]);
                }
            }
            else {
                $message = 'Sorry stock material is not available.';

                if ($stock > $safetyStock) {
                    $available = intval($stock - $safetyStock);
                    $message .= ' You can only use ' . $available;
                }

                Yii::$app->getSession()->setFlash('error', $message);
                return $this->render('update', [
                    'model' => $model,
                    'materialExpenditure' => $materialExpenditure,
                    'material' => $material,
                ]);
            }
        }

        $model->material_expenditure_id = $id;
        $model->material_id = $material_id;
        $model->qty = $requestedMaterial->qty;
        return $this->render('update', [
            'model' => $model,
            'materialExpenditure' => $materialExpenditure,
            'material' => $material,
        ]);
    }

    /**
     * Deletes an existing MaterialExpenditure model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MaterialExpenditure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialExpenditure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaterialExpenditure::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
