<?php

namespace api\modules\v1\controllers;

use yii;
use api\controllers\RangerController;
use yii\data\Pagination;
use api\components\RangerException;

class ArticleController extends RangerController
{

    public function actionList(array $params)
    {
        $pageSize = isset($params['query']['page_size']) && $params['query']['page_size']>0?$params['query']['page_size']:self::PAGE_SIZE;
        $page = isset($params['query']['page']) && $params['query']['page']>0?$params['query']['page']-1:0;

        $query = \common\models\Article::find();

        if(isset($params['query']['where']) && is_array($params['query']['where'])) {
            foreach ($params['query']['where'] as $where) {
                $query->andWhere($where);
            }
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' =>$countQuery->count(), 'pageSize' => $pageSize, 'page' => $page]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->orderBy(['id'=>SORT_DESC])->all();
        $result = [
            'models' => $models,
            'pages' => [
                'page' => $pages->getPage()+1,
                'page_size' => $pages->getPageSize(),
                'page_count' => $pages->getPageCount(),
                'total_count' => $pages->totalCount,
            ],
        ];
        return $result;
    }

    public function actionDetail(array $params)
    {
        if(!isset($params['query']['where']) || !is_array($params['query']['where'])){
            RangerException::throwException(RangerException::APP_ERROR_PARAMS,'where[]');
        }
        $query = Menu::find();
        foreach ($params['query']['where'] as $where) {
            $query->andWhere($where);
        }
        $result = $query->one();
        return $result->attributes;
    }

    public function actionCreate(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_CREATE);
    }

    public function actionUpdate(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_UPDATE);
    }

    public function actionDelete(array $params)
    {
        RangerException::throwException(RangerException::APP_ERROR_DELETE);
    }
}