<?php
/**
 * Description of CartItem
 *
 * @author Kaiste
 */
class CartItem implements ContentManipulator{
    private $id;
    private $user;
    private $course;
    private $dateAdded = ' CURRENT_DATE ';
    private $dbObj;
    
    
    //Class constructor
    public function CartItem($dbObj) {
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
     * Method that adds a  cart item into the database
     * @return JSON JSON encoded string/result
     */
    function add(){
        $sql = "INSERT INTO cart_item (user, course, date_added) "
                ."VALUES ('{$this->user}','{$this->course}',$this->dateAdded)";
        if($this->notEmpty($this->user,$this->course)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, cart item successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding  cart_item! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a  cart item
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM cart_item WHERE user = $this->user AND course = $this->course ";
        if($this->notEmpty($this->course,  $this->user)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  cart item successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting  cart item! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches cart items from database for JQuery Data Table
     * @param string $column Column user of the data to be fetched
     * @param string $condition Additional condition e.g  cart_item_id > 9
     * @param string $sort column user to be used as sort parameter
     * @return JSON JSON encoded cart item details
     */
    public function fetchForJQDT($draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM cart_item ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM cart_item WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){ 
                $result[] = array($r['id'], utf8_encode($r['user']), utf8_encode($r['course']), utf8_encode($r['date_added']), utf8_encode(' <button data-date-added="'.$r['date_added'].'" data-id="'.$r['id'].'" class="btn btn-info btn-small edit-cart_item"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span id="JQDTuserholder" class="hidden">'.$r['user'].'</span> <span id="JQDTcourseholder" class="hidden">'.$r['course'].'</span> </button> <button data-id="'.$r['id'].'" class="btn btn-danger btn-small delete-cart_item" title="Delete"><i class="btn-icon-only icon-trash"> </i> <span id="JQDTuserholder2" class="hidden">'.$r['user'].'</span></button>'));
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches cart items from database
     * @param string $column Column user of the data to be fetched
     * @param string $condition Additional condition e.g  cart_item_id > 9
     * @param string $sort column user to be used as sort parameter
     * @return JSON JSON encoded cart_item details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM cart_item ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM cart_item WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "user" =>  utf8_encode($r['user']), "course" =>  utf8_encode($r['course']), "dateAdded" =>  utf8_encode($r['date_added']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches cart items from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Cart Item list
     */
    public function fetchRaw($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM cart_item ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM cart_item WHERE $condition ORDER BY $sort";}
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
    
    /** Method that update single field detail of a  cart_item
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE cart_item SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  cart_item successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating  cart_item! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a  cart_item
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE cart_item SET user = '{$this->user}', course = '{$this->course}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  cart_item successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating  cart_item! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** getSingle() fetches the name of a cart item using the $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $column Requested column from the database
     * @param int $id Tutor id of the cart item whose name is to be fetched
     * @return string cart item column value
     */
    public static function getSingle($dbObj, $column, $id) {
        $thisColumnVal = '';
        $thisColumnVals = $dbObj->fetchNum("SELECT $column FROM cart_item WHERE id = '{$id}' LIMIT 1");
        foreach ($thisColumnVals as $thisColumnVals) { $thisColumnVal = $thisColumnVals[0]; }
        return $thisColumnVal;
    }
    
    /**
     * Method that returns count/total number of a particular cart item
     * @param Object $dbObj Datatbase connectivity object
     * @return int Number of users
     */
    public static function getRawCount($dbObj){
        $sql = "SELECT * FROM cart_item ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
    
    /**
     * Method that returns count/total number of a particular user
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $user UserId of the user whose cart items are to be fetched
     * @return int Count of user's cart items
     */
    public static function getSingleCount($dbObj, $user){
        $sql = "SELECT * FROM cart_item WHERE user = $user ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
}
