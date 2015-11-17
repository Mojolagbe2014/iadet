<?php
/**
 * Description of Course
 *
 * @author Kaiste
 */
class Course implements ContentManipulator{
    private $id;
    private $name;
    private $shortName;
    private $category;
    private $startDate;
    private $code;
    private $description;
    private $dateRegistered;
    private $status = 0;
    private $image;
    private $amount;
    private $promotionAmount = '0';
    private $tableName;
    private $dbObj;
    
    
    //Class constructor
    public function Course($dbObj, $tablePrefix='') {
        $this->tableName = $tablePrefix.'course';
        $this->dbObj = $dbObj;        $this->dateRegistered = time();
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
     * Method that adds a course into the database
     * @return JSON JSON encoded string/result
     */
    function add(){ 
        $sql = "INSERT INTO $this->tableName (name, amount, promotion_amount) VALUES ('{$this->name}','{$this->amount}','{$this->promotionAmount}')";
        if($this->notEmpty($this->name,$this->amount)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, course successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding course! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a course
     * @return JSON JSON encoded result
     */
    public function delete(){ 
        $sql = "DELETE FROM $this->tableName WHERE name = '$this->name' ";
        if($this->notEmpty($this->name)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, course successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting course! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches courses from database for JQuery Data Table
     * @param object $dbObj Main database instance object
     * @param string $dbPrefix Database table prefix
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded course details
     */
    public function fetchForJQDT($draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); $fetCourseStat = 'icon-check-empty'; $fetCourseRolCol = 'btn-warning'; $fetCourseRolTit = "Activate Promotional Offer";
        if(count($data)>0){
            foreach($data as $r){ 
                $fetCourseStat = 'icon-check-empty'; $fetCourseRolCol = 'btn-warning'; $fetCourseRolTit = "Activate Promotional Offer";
                if($r['status'] == 1){  $fetCourseStat = 'icon-check'; $fetCourseRolCol = 'btn-success'; $fetCourseRolTit = "De-activate Promotional Offer";}
                $result[] = array($r['name'], utf8_encode($r['amount']), utf8_encode($r['promotion_amount']), utf8_encode(' <button data-name="'.$r['name'].'" data-promotion-amount="'.$r['promotion_amount'].'"  data-amount="'.$r['amount'].'" class="btn btn-info btn-small edit-course"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> </button> <button data-name="'.$r['name'].'" class="btn btn-danger btn-small delete-course" title="Delete"><i class="btn-icon-only icon-trash"> </i></button> <button data-name="'.$r['name'].'" data-status="'.$r['status'].'"  class="btn '.$fetCourseRolCol.' btn-small activate-course"  title="'.$fetCourseRolTit.'"><i class="btn-icon-only '.$fetCourseStat.'"> </i></button>'));
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches courses from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded course details
     */
    public function fetch($column="*", $condition="", $sort="id", $dbObj=null){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); $thisCourseImage = '';
        if(count($data)>0){
            foreach($data as $r){
                if($dbObj != null){
                    $courseName = $r['fullname'];
                    $coursePromoStatus = Course::getSingle($dbObj, '', 'status', " name = '".$courseName."'"); 
                    $coursePromoAmt = Course::getSingle($dbObj, '', 'promotion_amount', " name = '".$courseName."'");
                    $courseAmount = Course::getSingle($dbObj, '', 'amount', " name = '".$courseName."'");
                    if($coursePromoAmt=='') {$coursePromoAmt =0;} if($courseAmount=='') {$courseAmount =0;}
                }
                $thisCourseImage = Course::getImage($this->dbObj, $r['id']); 
                $courseLink = MOODLE_URL.'course/view.php?id='.$r['id'];;
                $result[] = array("id" => $r['id'], "name" =>  utf8_encode($r['fullname']), "image" =>  utf8_encode($thisCourseImage), 'shortName' =>  utf8_encode($r['shortname']), 'category' => utf8_encode($r['category']), 'startDate' =>  utf8_encode($r['startdate']), 'code' =>  utf8_encode($r['idnumber']), 'description' =>  utf8_encode(stripcslashes(strip_tags(StringManipulator::trimStringToFullWord(160, $r['summary'])))), 'status' =>  utf8_encode($r['visible']), 'link' => utf8_encode($courseLink), 'dateRegistered' => utf8_encode($r['timecreated']), 'amount' => utf8_encode($courseAmount), 'formatedAmount' => utf8_encode(number_format($courseAmount)), 'formatedPromoAmount' => utf8_encode(number_format($coursePromoAmt)), 'promotionAmount' => utf8_encode($coursePromoAmt), 'promoStatus' => utf8_encode($coursePromoStatus));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** fetchByCategory fetches courses in a category and sub-categories
     * @param int $categoryId Category id
     * @param string $categoryTable Category table name
     * @param string $condition Additional condition
     */
    public function fetchByCategoryJSON($categoryId, $categoryTable, $dbObj=null, $condition=''){
        $data = $this->fetchByCategory($categoryId, $categoryTable, $condition);
        $result = array(); $thisCourseImage = '';
        if(count($data)>0){
            foreach($data as $r){
                if($dbObj != null){
                    $courseName = $r['fullname'];
                    $coursePromoStatus = Course::getSingle($dbObj, '', 'status', " name = '".$courseName."'"); 
                    $coursePromoAmt = Course::getSingle($dbObj, '', 'promotion_amount', " name = '".$courseName."'");
                    $courseAmount = Course::getSingle($dbObj, '', 'amount', " name = '".$courseName."'");
                    if($coursePromoAmt=='') {$coursePromoAmt =0;} if($courseAmount=='') {$courseAmount =0;}
                }
                $thisCourseImage = Course::getImage($this->dbObj, $r['id']); 
                $courseLink = MOODLE_URL.'course/view.php?id='.$r['id'];;
                $result[] = array("id" => $r['id'], "name" =>  utf8_encode($r['fullname']), "image" =>  utf8_encode($thisCourseImage), 'shortName' =>  utf8_encode($r['shortname']), 'category' => utf8_encode($r['category']), 'startDate' =>  utf8_encode($r['startdate']), 'code' =>  utf8_encode($r['idnumber']), 'description' =>  utf8_encode(stripcslashes(strip_tags(StringManipulator::trimStringToFullWord(160, $r['summary'])))), 'status' =>  utf8_encode($r['visible']), 'link' => utf8_encode($courseLink), 'dateRegistered' => utf8_encode($r['timecreated']), 'amount' => utf8_encode($courseAmount), 'formatedAmount' => utf8_encode(number_format($courseAmount)), 'formatedPromoAmount' => utf8_encode(number_format($coursePromoAmt)), 'promotionAmount' => utf8_encode($coursePromoAmt), 'promoStatus' => utf8_encode($coursePromoStatus));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** getImage() fetches a course's picture
     * @param Object $dbMoObj Instance of database connectivity Class to moodle database
     * @param int $courseId User id
     * @return string Link to user's picture
     */
    public static function getImage($dbMoObj, $courseId){
        $courseImage = '';
        $contextId = Context::getContextId($dbMoObj, MOODLE_DB_PREFIX, CONTEXT_COURSE, $courseId);
        $courseImage = MOODLE_URL.'pluginfile.php/'.$contextId.'/course/overviewfiles/'.Files::getCourseImage($dbMoObj, MOODLE_DB_PREFIX, $contextId);
        return $courseImage;
    }

    /** Method that fetches courses from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Courses list
     */
    public function fetchRaw($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $result = $this->dbObj->fetchAssoc($sql);
        return $result;
    }
    
    /** fetchByCategory fetches courses in a category and sub-categories
     * @param int $categoryId Category id
     * @param string $categoryTable Category table name
     * @param string $condition Additional condition
     */
    public function fetchByCategory($categoryId, $categoryTable, $condition=''){
        $courseArr = array();
        if($categoryId !=0){
            $courseArr = array_merge($courseArr, $this->dbObj->fetchAssoc("SELECT * FROM $this->tableName WHERE category = ".$categoryId." $condition "));
            $catDetails = $this->dbObj->fetchAssoc("SELECT * FROM $categoryTable WHERE parent = $categoryId $condition ");
            foreach ($catDetails as $catDetail){
                $courseArr = array_merge($courseArr, $this->fetchByCategory($catDetail['id'], $categoryTable));
            }
            return $courseArr;
        }
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
    
    /** Method that update single field detail of a course
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $dbPrefix Moodle table prefix
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $condition Condition
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $condition){ 
        $sql = "UPDATE course SET $field = '{$value}' WHERE $condition ";
        if(!empty($condition)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, course successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating course! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);  
    }

    

    
    /** getSingle() fetches the title of an course using the course $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $dbPrefix Database prefix
     * @param string $column Table's required column in the datatbase
     * @param int $condition Condition
     * @return string Name of the course
     */
    public static function getSingle($dbObj, $dbPrefix, $column, $condition) {
        $thisAsstReqVal = ''; $tableName = $dbPrefix.'course';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM $tableName WHERE $condition ");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
    
    /**
     * Method that returns count/total number of a particular course
     * @param Object $dbObj Datatbase connectivity object
     * @return int Number of courses
     */
    public static function getRawCount($dbObj, $dbPrefix){
        $tableName = $dbPrefix.'course';
        $sql = "SELECT * FROM $tableName ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
    
    /** Method that update details of a course
     * @return JSON JSON encoded success or failure message
     */
    public function update() { }
    
    /**
     * Method that returns count/total number of a particular lesson
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $id Course id of the lessons whose titles are to be fetched
     * @param string $dbPrefix Database table prefix
     * @return int Number of courses
     */
    public static function getSingleCategoryCount($dbObj, $id, $dbPrefix=''){
        $tableName = $dbPrefix.'course';
        $sql = "SELECT * FROM $tableName WHERE category = $id ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
    
    /** Method that update details of a course
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSpecial($dbObj, $amount, $promotionAmount, $courseName) { 
        $sql = "UPDATE course SET amount = '{$amount}', promotion_amount = '{$promotionAmount}' WHERE name = '$courseName' ";
        if(!empty($courseName)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  course successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating  course! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }
}
