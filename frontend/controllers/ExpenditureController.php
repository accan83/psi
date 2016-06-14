<?php

namespace frontend\controllers;

use common\models\Material;
use common\models\MaterialAccepted;
use common\models\MaterialAcceptedDetail;
use common\models\MaterialExpenditureDetail;
use common\models\RequestedMaterial;
use common\models\RequestedMaterialDetail;
use common\models\ReservedMaterial;
use common\models\Stock;
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
        $requested = RequestedMaterial::find()->where(['id' => $requested_material_id])->one();

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
                $rop = ExpenditureController::getReOrderPoint($material_id);
                if ($model->save()) {
                    $mStock = Stock::find()->where(['material_id' => $material_id])->one();
                    $mStock->qty = $stock - $model->qty;
                    $mStock->save();
                    if ($mStock->qty <= $rop) {
                        $message = 'You must re-order for Material ' . $material->code . '.';
                        $message .= 'The stock ' . $mStock->qty . 'kg only, and safety stock is ' . $material->safety_stock . 'kg';
                        Yii::$app->getSession()->setFlash('info', $message);
                    }
                    return $this->redirect(['view', 'id' => $materialExpenditure->id, 'requested_material_id' => $materialExpenditure->requested_material_id]);
                }
            }
            else {
                $message = 'Sorry stock material is not available.';

                if ($stock > $safetyStock) {
                    $available = intval($stock - $safetyStock);
                    $message .= ' You can only use ' . $available . 'kg';
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

    public static function getReOrderPoint($material_id)
    {
        $material_accepted_detail = MaterialAcceptedDetail::find()->where(['material_id' => $material_id])->all();
        $material_expenditure_detail = MaterialExpenditureDetail::find()->where(['material_id' => $material_id])->all();
        $item_count = 0;
        $leadtime = 0;

        foreach ($material_accepted_detail as $data) {
            $material_accepted = MaterialAccepted::find()->where(['id' => $data->material_accepted_id])->one();
            $reserved_material = ReservedMaterial::find()->where(['id' => $material_accepted->reserved_material_id])->one();
            $accepted_at = $material_accepted->created_at;
            $reserved_at = $reserved_material->created_at;

            $leadtime += $accepted_at - $reserved_at;
            $item_count++;
        }

        $item_count2 = 0;
        $demand = 0;

        foreach ($material_expenditure_detail as $data) {
            $qty = $data->qty;

            $demand += $qty;
            $item_count2++;
        }

        $material = Material::find()->where(['id' => $material_id])->one();
        $safety_stock = $material->safety_stock;
        $rop = $safety_stock;
        if ($item_count > 0 && $item_count2 > 0) {
            $leadtime_rate = $leadtime / $item_count;
            $demand_rate = $demand / $item_count2;

            $days = floor($leadtime_rate / (24*60*60));
            $weeks = floor($days / 7);
            $rop = floor($safety_stock + ($demand_rate * $weeks));
//            echo "ss = " . $safety_stock . "\n";
//            echo "demand = " . $demand_rate . "\n";
//            echo "leadtime = " . $weeks . "\n";
//            echo "rop = " . $rop . "\n";
        }

        return $rop;
    }
}
