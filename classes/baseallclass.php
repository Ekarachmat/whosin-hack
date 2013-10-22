<?php

require_once dirname(__FILE__) . '/baseclass.php';
require_once dirname(__FILE__) . '/calendarsclass.php';

abstract class BaseAllClass extends BaseClass
{
    protected $count;

    /**
     * Helper method to retrieve all models of a certain type
     * @param $collection
     * @param $modelClassName
     * @param array $filter
     * @param array $sort
     * @return array
     */
    protected function getAll($mongoCollectionName,Array $filter=array(),Array $sort=array(),$limit=null,$offset=0)
    {
        $this->setMongoCollectionName($mongoCollectionName);

        $models = array();
        $cursor = $this->getMongoCollection()->find($filter);
        if (!empty($sort)) $cursor->sort($sort);
        if (!empty($offset) || $offset>0) $cursor->skip($offset);
        if (!empty($limit)) $cursor->limit($limit);
        foreach ($cursor as $doc)
        {
            $model = new Calendars();
            $model->loadFromDoc($doc);

            $models[] = $model;
        }
        $this->count = $cursor->count();
        return $models;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function loadFromDoc($doc)
    {
        throw new Exception("Not relevant for AllModels"); //todo: improve, maybe don't extend BaseModel
    }
}
