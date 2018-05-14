<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/3/2018
 * Time: 7:19 PM
 */

require_once('./includes/QueryBuilder.php');

class Model {

    /**
     * Primary key for the model
     * @var string
     */
    public $primaryKey = "id";

    /**
     * The primary key type for
     * the model
     * @var string
     */
    protected $keyType = "int";

    /**
     * Fields that can be set
     * @var array
     */
    public $fillable = [];
    /**
     * Fields that should not
     * be shown in query
     * @var array
     */
    public $hidden = [];

    /**
     * Table name for model
     * @var string
     */
    protected $tableName;

    /**
     * Attributes of the model
     * @var array
     */
    public $attributes = [];

    /**
     * Whether the model has
     * been edited or not
     * @var bool
     */
    public $edited = false;

    /**
     * Whether the model has been
     * retrieved from the
     * database or not
     * @var bool
     */
    public $exists = false;

    /**
     * Model constructor.
     */
    public function __construct($array = []) {

        if(!empty($array)){
            foreach($array as $key=>$item){
                if(in_array($key, $this->fillable)) $this->$key = $item;
            }
        }
        if(!isset($this->tableName)){
            $this->tableName = get_class($this).'s';
        }

        return $this;
    }

    /**
     * Model Get Accessor
     * @param $name
     * @return mixed|null
     */
    public function __get($name){
        if(isset($this->$name)){
            return $this->$name;
        }
        else if(isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        else if(method_exists($this, 'get'.ucfirst($name).'Attribute')){
            $methodName = 'get'.ucfirst($name).'Attribute';
            return $this->$methodName();
        }
        else{
            return null;
        }
    }

    /**
     * Model Set Accessor
     * @param $name
     * @param $value
     */
    public function __set($name, $value){
        $this->attributes[$name] = $value;
        $this->edited = true;
    }

    /**
     * Finds the object from the database
     * where the given value matches
     * the primary key
     *
     * @param $value
     * @return array
     * @throws QueryNotCreatedException
     */
    public static function find($value){
        $instance = new static;
        return QueryBuilder::newSelectQuery($instance)->where($instance->primaryKey, $value)->first();
    }

    /**
     * Creates a QueryBuilder with a where clause
     * for this model
     *
     * @param $key
     * @param $value
     * @return Object
     * @throws QueryNotCreatedException
     */
    public static function where($key, $value){
        $instance = new static;
        return QueryBuilder::newSelectQuery($instance)->where($key, $value);
    }

    /**
     * Returns all the objects from the database
     * for this model
     *
     * @return Object
     */
    public static function all(){
        $instance = new static;
        return QueryBuilder::newSelectQuery($instance)->get();
    }

    /**
     * Returns a count of objects from the database
     * for this model
     *
     * @return int
     */
    public static function count(){
        $instance = new static;
        return QueryBuilder::newCountQuery($instance, [$instance->primaryKey]);
    }

    public function save(){
        return QueryBuilder::newInsertQuery($this);
    }

    /**
     * @return mixed
     * @throws ObjectNotCreatedException
     */
    public function update($updates){
        if(!$this->exists){
            throw new ObjectNotCreatedException("Please create ".get_class($this)." first");
        }
        return QueryBuilder::newUpdateQuery($this, $updates);
    }
}