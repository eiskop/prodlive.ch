<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use app\models\Availability;
use yii\data\ArrayDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AvailabilitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Störungen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="availability-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php

$db = new yii\db\Connection([
    'dsn' => 'mysql:host=localhost;dbname=prodlive',
    'username' => 'prodlive',
    'password' => 'JeldWen2017',
    'charset' => 'utf8',
]);
date_default_timezone_set('Europe/Zurich');

$posts = $db->createCommand("SELECT availability.id, FROM_UNIXTIME(start_time, '%Y-%W') as 'J-W', FROM_UNIXTIME(start_time, '%d.%m.%Y') as 'Start Datum',  FROM_UNIXTIME(start_time, '%d.%m.%Y %h:%i') as Start, FROM_UNIXTIME(end_time, '%d.%m.%Y %h:%i') as Ende, (duration_sec) as 'Dauer(sek)', format(duration_sec/60, 0) as 'Dauer(min)', Format(duration_sec/60/60, 2) as 'Dauer(h)', fault_code.name as Störungsbeschreibung, fault_code_group.name as Störungsgruppe, work_centre.name as Arbeitstation FROM `availability`
    LEFT JOIN fault_code on availability.fault_code_id = fault_code.id
    LEFT JOIN fault_code_group on fault_code.fault_code_group_id = fault_code_group.id
    LEFT JOIN work_centre on availability.work_centre_id = work_centre.id
ORDER BY `availability`.`id`  ASC

")->queryAll();

          // echo var_dump($posts);
          // exit;

//echo var_dump($dataProvider->getData());
//$data = array_merge($orders, $orders2, $orders3);
$provider = new ArrayDataProvider([
    'allModels' => $posts,
    'pagination' => [
        'pageSize' => 0,
    ],
    'sort' => [
        'attributes' => ['id', 'deadline'],
    ],

]);
// get the rows in the currently requested page
$rows = $provider->getModels();

$count = 0;
echo '<table border=1>';
foreach ($rows as $k => $v) {
    if ($count == 0) {
        echo '<tr>';
        foreach ($rows[$k] as $title=>$va) {
            echo '<th>'.$title.'</th>';
        }
        echo '</tr>';
        echo '<tr>';
        foreach ($rows[$k] as $title=>$va) {
            echo '<td>'.$va.'</td>';
        }        
        echo '</tr>';
    }
    else {
        echo '<tr>';
        foreach ($rows[$k] as $title=>$va) {
            echo '<td>'.$va.'</td>';
        }
        echo '</tr>';
    }
    

    $count++;
}
?>

</div>
