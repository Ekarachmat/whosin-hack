<?php

require_once dirname(__FILE__) . '/baseallclass.php';

class AllCalendars extends BaseAllClass
{
    public function __construct() {
        $this->setMongoDatabaseName(WHOSINDB);
    }

    public function getCalendars($filter=array(),$sort=array(),$limit=25,$offset=0) {
        return $this->getAll(CALENDARS_COLLECTION,$filter,$sort,$limit,$offset);
    }
}