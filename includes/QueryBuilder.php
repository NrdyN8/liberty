<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/3/2018
 * Time: 8:10 PM
 */

require_once('./includes/db.php');

class QueryBuilder {

    /**
     * The query string being generated
     *
     * @var string $query
     */
    private $query;

    /**
     * The variables to be inserted into the
     * query via PDO
     *
     * @var array $queryVariables
     */
    private $queryVariables = [];

    /**
     * The model we are building
     *
     * @var Model $model
     */
    private $model;

    private $isCount = false;

    public function set($key, $value){
        $this->$key = $value;
        return $this;
    }

    /**
     * Generic class to create a query
     *
     * @param String $_query
     * @return QueryBuilder
     */
    public function createNewQuery($_query, $overwrite = false){
        if(!isset($this->query) || $overwrite){
            $this->query = $_query;
        }
        return $this;
    }

    /**
     * Adds a where clause to the function
     *
     * @param $key
     * @param $value
     * @throws QueryNotCreatedException
     * @return QueryBuilder
     */
    public function where($key, $value, $operation = "="){
        if(is_null($this->query)){
            throw new QueryNotCreatedException("Please run 'query()' first");
        }
        $this->query .= ' WHERE '.$key.' '.$operation.' :'.$key;
        $this->queryVariables[$key] = $value;
        return $this;
    }

    /**
     * @return Object
     */
    public function get(){
        $db = new DB();
        $results = $db->select($this->query, $this->queryVariables);
        $returned_results = new Collection();
        foreach($results as $result){
            $object = clone $this->model;
            foreach($result as $key=>$value){
                $object->$key = $value;
            }
            $object->exists = true;
            $object->edited = false;
            $returned_results->add($object);
        }
        return $returned_results;
    }

    /**
     * @return null
     * @throws QueryNotCreatedException
     */
    public function create(){
        $db = new DB();
        $id = $db->insert($this->query, $this->queryVariables);
        $this->queryVariables = [$this->model->primaryKey => $id];
        return $this->createNewQuery("SELECT * FROM ".$this->model->tableName." WHERE ".$this->model->primaryKey.' = :'.$this->model->primaryKey, true)->first();
    }

    /**
     * @throws QueryNotCreatedException
     */
    public function update(){
        $db = new DB();
        $db->update($this->query, $this->queryVariables);
        foreach($this->queryVariables as $key => $queryVariable){
            $this->model->$key = $queryVariable;
        }
    }

    /**
     * Gets the first record returned
     *
     * @throws QueryNotCreatedException
     */
    public function first(){
        if(is_null($this->query)){
            throw new QueryNotCreatedException("Please run 'query()' first");
        }
        $this->query .= ' LIMIT 1';
        $results = $this->get();
        if($results->count() === 0) return null;
        return $results->first();
    }

    /**
     * @return mixed
     * @throws QueryNotCreatedException
     * @throws QueryNotValidException
     */
    public function count(){
        if(!$this->isCount){
            throw new QueryNotValidException('Query requires count');
        }
        return $this->first()->count;
    }

    public function setModel($model) {
        $this->model = $model;

        return $this;
    }

    public function getKeys(){
        $keys = [];
        foreach($this->model->attributes as $key=>$column){
            array_push($keys, $key);
        }
        return implode(", ", $keys);
    }

    /**
     * Creates a new QueryBuilder to generate the SQL call
     *
     * @param $model
     * @param $fields
     * @throws InvalidArgumentException
     * @return QueryBuilder
     */
    static public function newSelectQuery($model, $fields = ["*"]){
        if(!is_array($fields)){
            throw new InvalidArgumentException('$fields needs to be an array');
        }
        return (new static)->setModel($model)->createNewQuery("SELECT ".implode(', ', $fields)." FROM ".$model->tableName);
    }

    /**
     * Creates and returns the count of the model
     * passed to it
     *
     * @param $model
     * @param array $fields
     * @return mixed
     */
    static public function newCountQuery($model, $fields = ["id"]) {
        if(!is_array($fields)){
            throw new InvalidArgumentException('$fields needs to be an array');
        }
        if(count($fields) > 1){
            throw new InvalidArgumentException('Too many columns provided');
        }

        return (new static)->setModel($model)->createNewQuery("SELECT COUNT(".$fields[0].") AS count FROM ".$model->tableName)->set("isCount", true)->count();
    }

    static public function newInsertQuery($model){
        $instance = new static;
        $instance->setModel($model);
        $instance->queryVariables = $model->attributes;
        $variableKeys = array_map(function($key){
            return ":".$key;
        }, array_keys($instance->model->attributes));
        return $instance->createNewQuery(
            "INSERT INTO " .$model->tableName.' ('.$instance->getKeys().') VALUES ('.implode(', ', $variableKeys).');'
        )->create();
    }

    static public function newUpdateQuery($model, $updates) {
        if(empty($updates)){
            throw new InvalidArgumentException("Updates need to be provided");
        }
        $instance = new static;
        $instance->setModel($model);
        $instance->queryVariables = array_filter($updates, function($key) use($instance){
            return in_array($key, $instance->model->fillable);
        }, ARRAY_FILTER_USE_KEY);
        $updates = array_map(function($key) use($instance){
            return $key." = :".$key;
        }, array_keys($instance->queryVariables));
        return $instance->createNewQuery(
            "UPDATE " .$model->tableName.' SET '.implode(', ', $updates).' WHERE '.$model->primaryKey.' = '.$model->attributes[$model->primaryKey].';'
        )->update();
    }
}