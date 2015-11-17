<?php
/**
 * Description of PurchaseRecord
 *
 * @author Kaiste
 */
class PurchaseRecord implements ContentManipulator{
    private $id;
    private $transactionId;
    private $course;
    private $user;
    private $amount;
    private $currency;
    private $method;
    private $state;
    private $itemType;
    private $mode = 'full';
    private $datePurchased;
    private $tableName;
    private $dbObj;
    
    
    //Class constructor
    public function PurchaseRecord($dbObj, $tableName = 'purchase_record', $tablePrefix='') {
        $this->dbObj = $dbObj; $this->tableName = $tablePrefix.$tableName;
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
     * Method that adds a user's purchase courses into the database
     * @return JSON JSON encoded string/result
     */
    function add(){
        $sql = "INSERT INTO $this->tableName (transaction_id, course, user, amount, currency, method, state, date_purchased, item_type, mode) "
                ."VALUES ('{$this->transactionId}','{$this->course}','{$this->user}','{$this->amount}','{$this->currency}','{$this->method}','{$this->state}','{$this->datePurchased}','{$this->itemType}','{$this->mode}')";
        if($this->notEmpty($this->user, $this->course)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user's purchase record successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding user's purchase record! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a purchased course record
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM $this->tableName WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user's  purchase record successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting user's  purchase record! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    
    /** Method that fetches purchased courses from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded course details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "transactionId" =>  utf8_encode($r['transaction_id']), "user" =>  utf8_encode($r['user']), "mode" =>  utf8_encode($r['mode']), "course" =>  utf8_encode($r['course']), "amount" =>  utf8_encode($r['amount']), "currency" =>  utf8_encode($r['currency']), "method" =>  utf8_encode($r['method']), "state" =>  utf8_encode($r['state']), "itemType" =>  utf8_encode($r['item_type']), 'datePurchased' => utf8_encode($r['date_purchased']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches course purchase record from database for JQuery Data Table
     * @param object $dbMoObj Moodle database instance object
     * @param string $dbPrefix Database table prefix
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g  purchase_record_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded course purchase record details
     */
    public function fetchForJQDT($dbMoObj, $dbPrefix, $draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); $thisCourse = '';
        if(count($data)>0){
            foreach($data as $r){ 
                if($r['item_type']=='course'){ $thisCourse = Course::getSingle($dbMoObj, $dbPrefix, 'fullname', 'id='.$r['course']); }
                elseif($r['item_type']=='category') { $thisCourse = CourseCategory::getSingle($dbMoObj, $dbPrefix, 'name', 'id='.$r['course']);}
                $result[] = array(utf8_encode($r['transaction_id']), utf8_encode(User::getSingle($dbMoObj, $dbPrefix, 'username', $r['user'])), utf8_encode($thisCourse), utf8_encode($r['item_type']), utf8_encode($r['amount']), utf8_encode($r['currency']), utf8_encode($r['method']), utf8_encode($r['state']), utf8_encode($r['date_purchased']), utf8_encode($r['mode']));//
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        $this->dbObj->close();
        //header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches purchase record from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Purchase record list
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
    
    /** Method that update single field detail of a purchased course record
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE purchase_record SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, purchased course record successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating purchased course record! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    public function update() { }
    
    /**
     * Method that returns count/total number of a particular user purchased courses<br/>
     */
    public function getPurchasedCourseCount(){
        $sql = "SELECT * FROM purchase_record WHERE user = $this->user";
        if(!empty($this->user)){
            $result = $this->dbObj->query($sql);
            $totalData = mysqli_num_rows($result);
            if($result !== false){ $json = array("status" => 1, "count" => $totalData); }
            else{ $json = array("status" => 2, "msg" => "Error fetching course count! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
}
