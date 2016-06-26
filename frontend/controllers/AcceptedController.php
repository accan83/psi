<?php

namespace frontend\controllers;

use common\models\Material;
use common\models\MaterialAcceptedDetail;
use common\models\ReservedMaterial;
use common\models\ReservedMaterialDetail;
use common\models\Stock;
use Yii;
use common\models\MaterialAccepted;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AcceptedController implements the CRUD actions for MaterialAccepted model.
 */
class AcceptedController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'update', 'create', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        if (Yii::$app->user->identity->username != 'gudang') {
            return $this->redirect('site/index');
        }

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all MaterialAccepted models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ReservedMaterial::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialAccepted model.
     * @param integer $id
     * @param $reserved_material_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id, $reserved_material_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'reserved_material_id' => $reserved_material_id,
        ]);
    }

    /**
     * Creates a new MaterialAccepted model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $reserved_material_id
     * @return mixed
     */
    public function actionCreate($reserved_material_id)
    {
        $model = new MaterialAccepted();
        $requested = ReservedMaterial::find()->where(['id' => $reserved_material_id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'reserved_material_id' => $reserved_material_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'reserved' => $requested,
            ]);
        }
    }

    /**
     * Updates an existing MaterialAccepted model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $material_id)
    {
        $model = new MaterialAcceptedDetail();
        $materialAccepted = MaterialAccepted::find()->where(['id' => $id])->one();
        $material = Material::find()->where(['id' => $material_id])->one();
        $reservedMaterial = ReservedMaterialDetail::find()->where(['reserved_material_id' => $materialAccepted->reserved_material_id, 'material_id' => $material->id])->one();

        if ($model->load(Yii::$app->request->post())) {
            $stock = $material->stock->qty;
            if ($model->save()) {
                $mStock = Stock::find()->where(['material_id' => $material_id])->one();
                $mStock->qty = $stock + $model->qty;
                $mStock->save();
                return $this->redirect(['view', 'id' => $materialAccepted->id, 'reserved_material_id' => $materialAccepted->reserved_material_id]);
            }
        }

        $model->material_accepted_id = $id;
        $model->material_id = $material_id;
        $model->qty = $reservedMaterial->qty;
        return $this->render('update', [
            'model' => $model,
            'materialAccepted' => $materialAccepted,
            'material' => $material,
        ]);
    }

    /**
     * Deletes an existing MaterialAccepted model.
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
     * Finds the MaterialAccepted model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialAccepted the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaterialAccepted::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
