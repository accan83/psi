<?php

namespace frontend\controllers;

use common\models\Material;
use common\models\MaterialExpenditure;
use common\models\MaterialExpenditureDetail;
use common\models\Stock;
use common\models\WastedMaterialDetail;
use Yii;
use common\models\WastedMaterial;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WastedController implements the CRUD actions for WastedMaterial model.
 */
class WastedController extends Controller
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
     * Lists all WastedMaterial models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MaterialExpenditure::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WastedMaterial model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $material_expenditure_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'material_expenditure_id' => $material_expenditure_id,
        ]);
    }

    /**
     * Creates a new WastedMaterial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($material_expenditure_id)
    {
        $model = new WastedMaterial();
        $requested = MaterialExpenditure::find()->where(['id' => $material_expenditure_id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'material_expenditure_id' => $material_expenditure_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'requested' => $requested,
            ]);
        }
    }

    /**
     * Updates an existing WastedMaterial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $material_id)
    {
        $model = new WastedMaterialDetail();
        $wastedMaterial = WastedMaterial::find()->where(['id' => $id])->one();
        $material = Material::find()->where(['id' => $material_id])->one();
        $materialExpenditure = MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $wastedMaterial->material_expenditure_id, 'material_id' => $material->id])->one();

        if ($model->load(Yii::$app->request->post())) {
            $stock = $material->stock->qty;
            if ($model->save()) {
                $mStock = Stock::find()->where(['material_id' => $material_id])->one();
                $mStock->qty = $stock + $model->qty;
                $mStock->save();
                return $this->redirect(['view', 'id' => $wastedMaterial->id, 'material_expenditure_id' => $wastedMaterial->material_expenditure_id]);
            }
        }

        $model->wasted_material_id = $id;
        $model->material_id = $material_id;
        $model->qty = $materialExpenditure->qty;
        return $this->render('update', [
            'model' => $model,
            'wastedMaterial' => $wastedMaterial,
            'material' => $material,
        ]);
    }

    /**
     * Deletes an existing WastedMaterial model.
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
     * Finds the WastedMaterial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WastedMaterial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WastedMaterial::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
