<?php
/**
 * Description of Context
 *
 * @author Kaiste
 */
class Context implements ContentManipulator{
    private $id;
    private $contextLevel;
    private $instanceId;
    private $path;
    private $depth;
    private $tableName;
    private $dbObj;
    
    
    //Class constructor
    public function Context($dbObj, $tablePrefix='') {
        $this->tableName = $tablePrefix.'context';
        $this->dbObj = $dbObj;   
    }
    
    //Using Magic__set and __get
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    
    /**  
     * Method that adds a context into the database
     * @return JSON JSON encoded string/result
     */
    function add(){ }

    /** 
     * Method for deleting a context
     * @return JSON JSON encoded result
     */
    public function delete(){ }
    
    /** Method that fetches contexts from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded context details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "contextLevel" =>  utf8_encode($r['contextlevel']), "instanceId" =>  utf8_encode($r['instanceid']), 'path' =>  utf8_encode($r['path']), 'depth' => utf8_encode($r['depth']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches contexts from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Contexts list
     */
    public function fetchRaw($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM context WHERE $condition ORDER BY $sort";}
        $result = $this->dbObj->fetchAssoc($sql);
        return $result;
    }
    
    /** Empty string checker  
     * @return Booloean True|False
     */
    public function notEmpty() {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) { return false; } 
            else {continue; }
        }
        return true;
    }
    
    /** Method that update single field detail of a context
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){ }

    /** Method that update details of a context
     * @return JSON JSON encoded success or failure message
     */
    public function update() { }
      
    /** getSingle() fetches the title of an context using the context $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $condition Context addition query
     * @return string Name of the context
     */
    public static function getSingle($dbObj, $dbPrefix, $column, $condition = ' 1 = 1 ') {
        $thisAsstReqVal = ''; $tableName = $dbPrefix.'context';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM $tableName WHERE $condition ");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
    
    /** getCourseImage() fetches the image name
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $dbPrefix Moodle database name prefix
     * @param int $contextId Context Id of the course
     * @return string Name of the files
     */
    public static function getContextId($dbObj, $dbPrefix, $contextLevel, $instanceId) {
        $thisAsstReqVal = ''; $tableName = $dbPrefix.'context';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT path FROM $tableName WHERE contextlevel = '".$contextLevel."' AND instanceid = '".$instanceId."' LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { 
            $thisAsstReqVal = $thisAsstReqVals[0]; 
            if(strrpos($thisAsstReqVal, '/')) { $thisAsstReqVal = explode('/', $thisAsstReqVal); $thisAsstReqVal = end($thisAsstReqVal);}
        }
        return $thisAsstReqVal;
    }
    
    /**
     * Method that returns count/total number of a particular context
     * @param Object $dbObj Datatbase connectivity object
     * @return int Number of contexts
     */
    public static function getRawCount($dbObj, $dbPrefix){
        $tableName = $dbPrefix.'context';
        $sql = "SELECT * FROM $tableName ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
}
