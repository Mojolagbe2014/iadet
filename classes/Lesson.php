<?php
/**
 * Description of Lesson
 *
 * @author Kaiste
 */
class Lesson implements ContentManipulator{
    private $id;
    private $form;
    private $title;
    private $body;
    private $startDate;
    private $endDate;
    private $tutor;
    private $material;
    private $dateAdded = " CURRENT_DATE ";
    private $status = 0;
    private $parent;
    private $tableName;
    private $dbObj;
    
    
    //Class constructor
    public function Lesson($dbObj, $tablePrefix='') {
        $this->tableName = $tablePrefix.'lesson';
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
     * Method that adds a lesson into the database
     * @return JSON JSON encoded result
     */
    public function add(){ }

    /** 
     * Method for deleting a lesson
     * @return JSON JSON encoded result
     */
    public function delete(){ }
    
    /** Method that fetches lessons from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g lesson_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded lesson details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "title" =>  utf8_encode($r['title']), "body" =>  utf8_encode($r['body']), 'form' =>  utf8_encode($r['form']), 'startDate' => utf8_encode($r['start_date']), 'endDate' =>  utf8_encode($r['end_date']), 'tutor' =>  utf8_encode($r['tutor']), 'material' =>  utf8_encode($r['material']), 'status' =>  utf8_encode($r['status']), 'dateAdded' =>  utf8_encode($r['date_added']), 'parent' =>  utf8_encode($r['parent']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches lessons from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Lesson list
     */
    public function fetchRaw($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
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
    
    /** Method that update single field detail of a lesson
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){ }

    /** Method that update details of a lesson
     * @return JSON JSON encoded success or failure message
     */
    public function update() { }
    
    /**
     * Method that returns count/total number of lessons
     * @param Object $dbObj Datatbase connectivity object
     * @param string $dbPrefix Database table prefix
     * @return int Number of lessons
     */
    public static function getRawCount($dbObj, $dbPrefix=''){
        $tableName = $dbPrefix.'lesson';
        $sql = "SELECT * FROM $tableName ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
    
    /**
     * Method that returns count/total number of a particular lesson
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $id Course id of the lessons whose titles are to be fetched
     * @param string $dbPrefix Database table prefix
     * @return int Number of lessons
     */
    public static function getSingleCourseCount($dbObj, $id, $dbPrefix=''){
        $tableName = $dbPrefix.'lesson';
        $sql = "SELECT * FROM $tableName WHERE course = $id ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
}
