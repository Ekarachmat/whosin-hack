<?php

require_once dirname(__FILE__) . '/baseclass.php';

class Calendars extends BaseClass {
	
	private $doc;
    private $id;

	private $email;
	private $first_name;
	private $last_name;
	private $auth_token;
	private $date_created;

	public function __construct() {
	    $this->setMongoDatabaseName(WHOSINDB);
	    $this->setMongoCollectionName(CALENDARS_COLLECTION);
	}

    public function toDoc() {
        $doc = array('_id'=>$this->getId());

        if(!empty($this->email)) {
            $doc['email'] = $this->email;
        }

        if(!empty($this->first_name)) {
            $doc['first_name'] = $this->first_name;
        }

        if(!empty($this->last_name)) {
            $doc['last_name'] = $this->last_name;
        }

        if(!empty($this->auth_token)) {
            $doc['auth_token'] = $this->auth_token;
        }

        $doc['date_created'] = $this->dateCreated ? $this->dateCreated : new MongoDate();

        return($doc);
    }

    public function loadFromDoc(Array $doc) {
        //TODO Some checking to ensure the doc we got back is what we expected...
        $this->doc = $doc;
        if(isset($doc['_id'])) {
            $this->setId($doc['_id']);
        }
        if(isset($doc['email'])) {
            $this->setEmail($doc['email']);
        }
        if(isset($doc['first_name'])) {
            $this->setFirstName($doc['first_name']);
        }
        if(isset($doc['last_name'])) {
            $this->setLastName($doc['last_name']);
        }
        if(isset($doc['auth_token'])) {
            $this->setAuthToken($doc['auth_token']);
        }
        if(isset($doc['date_created'])) {
            $this->setDateCreated($doc['date_created']);
        }
    }

    public function save() {
        $this->getMongoCollection()->save($this->toDoc(), array('safe'=>true));
    }

    public function setId($id) {
        if(is_string($id)) {
            $id = new MongoId($id);
        } elseif(!is_a($id, 'MongoId')) {
            throw new InvalidArgumentException("Argument must be a MongoId or string");
        }

        $this->id = $id;
    }

	public function setEmail($newEmail) {
		$this->email = $newEmail;
	}

	public function setFirstName($newFirstName) {
		$this->first_name = $newFirstName;
	}

	public function setLastName($newLastName) {
		$this->last_name = $newLastName;
	}

	public function setAuthToken($newAuthToken) {
		$this->auth_token = $newAuthToken;
	}

    public function setDateCreated($dateCreated) {
        if(is_string($dateCreated)) {
            $dateCreated = new MongoDate(strtotime($dateCreated));
        } elseif(!is_a($dateCreated, 'MongoDate')) {
            throw new InvalidArgumentException('Argument must be a MongoDate or formatted date string');
        }
        $this->dateCreated = $dateCreated;
    }    

    public function getId() {
        if(empty($this->id)) {
            $this->id = new MongoId;
        }
        return $this->id;
    }	

    public function getEmail() {
    	return $this->email;
    }

    public function getFirstName() {
    	return $this->first_name;
    }

    public function getLastName() {
    	return $this->last_name;
    }

    public function getAuthToken() {
    	return $this->auth_token;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function toJson()
    {
        $doc = $this->toDoc();

        $json = array("_id"=>''.$this->getId());

        $json['_id'] = ''.$this->getId(); // convert to a string

        $json['email'] = $doc['email'];
        $json['first_name'] = $doc['first_name'];
        $json['last_name'] = $doc['last_name'];

        if (isset($doc['auth_token'])) {
            $json['auth_token'] = $doc['auth_token'];
        }

        if (isset($doc['date_created'])) {
            // convert to friendly date
            $json['date_created'] = date(DATE_ISO8601,$this->getDateCreated()->sec);
        }
        return $json;
    }

}