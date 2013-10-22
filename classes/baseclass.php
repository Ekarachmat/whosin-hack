<?php

class BaseClass {

    private $mongo;
    private $mongoDatabaseName;
    private $mongoCollectionName;
    private $mongoDatabase;

    private $mongoCollection;

    protected function setMongoDatabaseName($mongoDatabaseName) {
        $this->mongoDatabaseName = $mongoDatabaseName;

        // Reset the database being used so it gets lazily loaded again next time needed.
        $this->mongoDatabase = null;
    }

    protected function setMongoCollectionName($mongoCollectionName) {
        $this->mongoCollectionName = $mongoCollectionName;

        // Reset the collecton being used so it gets lazily loaded again next time needed.
        $this->mongoCollection = null;
    }

    protected function getMongo() {
        if ($this->mongo == null) {

            $user = MONGO_USER;
            $password = MONGO_PASSWORD;
            $repSet = MONGO_REPSET;

            if (!empty($user) && !empty($password)) {
                $mongoConnStr = 'mongodb://'.MONGO_USER.':'.MONGO_PASSWORD.'@';
                $mongoConnStr .= MONGO_HOST;

                //NB You need to connect to 'admin' DB on MongoLab
                $mongoConnStr .= '/admin';
            } else {
                $mongoConnStr = 'mongodb://';
                $mongoConnStr .= MONGO_HOST;
            }

            try {
                if (empty($repSet)) {
                    $this->mongo = new MongoClient($mongoConnStr);
                } else {
                    $this->mongo = new MongoClient($mongoConnStr, array('replicaSet'=>MONGO_REPSET));
                }
            }
            catch (MongoConnectionException $ex) {
                // Hide the real error (just put it in the logs) and show a sanitised generic error.
                $msg = 'Failed to connect to Mongo ('.$mongoConnStr.')';
                if (!empty($repSet)) {
                    $msg .= ', repset='.MONGO_REPSET;
                }
                $msg .= ' : '.$ex->getMessage();

                error_log($msg);
                throw new Exception('Error connecting to database');
            }
        }

        return $this->mongo;
    }

    protected function getMongoDatabase() {
        if (!$this->mongoDatabase) {
            if (empty($this->mongoDatabaseName)) {
                throw new Exception('No MongoDB name has been specified in class '.get_class($this));
            }
            $this->mongoDatabase = $this->getMongo()->selectDB($this->mongoDatabaseName);
        }

        return $this->mongoDatabase;
    }

    protected function getMongoCollection() {
        if (!$this->mongoCollection) {
            if (empty($this->mongoCollectionName)) {
                throw new Exception('No MongoCollection name has been specified in class '.get_class($this));
            }
            $this->mongoCollection = $this->getMongoDatabase()->selectCollection($this->mongoCollectionName);
        }

        return $this->mongoCollection;
    }

    protected function getMongoDate() {
        return new MongoDate();
    }
	
}