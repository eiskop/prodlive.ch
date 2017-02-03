<?php

namespace app\controllers;

use Yii;
use app\models\Availability;
use app\models\AvailabilitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AvailabilityController implements the CRUD actions for Availability model.
 */
class AvailabilityController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Availability models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AvailabilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Availability models.
     * @return mixed
     */
    public function actionIndexExport()
    {
        $searchModel = new AvailabilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_export', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Availability model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Availability model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Availability();
        $searchModel = new AvailabilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where('work_centre_id = '.Yii::$app->user->identity->work_centre_id);

        if ($model->load(Yii::$app->request->post())) {

            //echo '<pre>', var_dump(Yii::$app->request->post());
            //echo '<pre>', var_dump($model->start_time);
            $model->start_time = strtotime(date('Y-m-d', time()).' '.$model->start_time.':00');    
            $model->end_time = strtotime(date('Y-m-d', time()).' '.$model->end_time.':00');    
            $model->duration_sec = $model->end_time-$model->start_time;

             
            //echo '<pre>', var_dump($model->start_time);
            $model->work_centre_id = Yii::$app->user->identity->work_centre_id;
            
            $model->created_at = time();
            $model->created_by = Yii::$app->user->id;

            $model->save();
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Availability model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $start_date = date('Y-m-d', $model->start_time);
        $end_date = date('Y-m-d', $model->end_time);
        $model->start_time = date('H:i', $model->start_time);
        $model->end_time = date('H:i', $model->end_time);

        if ($model->load(Yii::$app->request->post())) {
       //     echo var_dump($model->start_time);

            $model->start_time = strtotime($start_date.' '.$model->start_time.':00');    
            $model->end_time = strtotime($end_date.' '.$model->end_time.':00');    
            $model->duration_sec = $model->end_time-$model->start_time;

            $model->updated_at = time();
            $model->updated_by = Yii::$app->user->id;
            $model->save();
            return $this->redirect(['create']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Availability model.
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
     * Finds the Availability model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Availability the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Availability::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
