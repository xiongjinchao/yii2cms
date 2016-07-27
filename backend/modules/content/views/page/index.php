<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '单页管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <p>
        <?= Html::a('<i class="fa fa-plus-circle"></i> 创建单页', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '<div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title pull-left">'.$this->title.'</h3><span class=pull-right>{summary}</span></div>
            <div class="box-body">{items}</div>
            <div class="box-footer">{pager}</div>
            </div>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'name',
                'value'=>function($model){
                    return $model->getSpace().$model->name;
                }
            ],
            'tag',
            [
                'attribute'=>'created_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime','php:Y-m-d H:i:s'],
            ],
            [
                'attribute'=>'visible',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->visible == $model::VISIBLE_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['visible','id'=>$model->id], ['title' => '可见']) ;
                },
                'headerOptions'=>['style'=>'width:5%']
            ],
            [
                'attribute'=>'audit',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a($model->audit == $model::AUDIT_ENABLE?'<span class="glyphicon glyphicon-ok"></span>':'<span class="glyphicon glyphicon-remove"></span>', ['audit','id'=>$model->id], ['title' => '审核']) ;
                },
                'headerOptions'=>['style'=>'width:5%']
            ],
            ['class' => 'yii\grid\ActionColumn'],
            [
                'format'=>'raw',
                'value'=>function($model){
                    $parent = $model->getParent();
                    if($model->lft>1&&($model->lft!=$parent->lft+1)){
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up','id'=>$model->id], ['title' => '上移']) ;
                    }else{
                        return '';
                    }
                }
            ],
            [
                'format'=>'raw',
                'value'=>function($model){
                    $parent = $model->getParent();
                    $lastBrother = $model->getLastBrother();
                    if($model->id!=$lastBrother->id&&($model->rgt!=$parent->rgt-1)){
                        return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down','id'=>$model->id], ['title' => '下移']) ;
                    }else{
                        return '';
                    }
                }
            ],
        ],
    ]); ?>

</div>
