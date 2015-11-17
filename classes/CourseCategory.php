<?php
/**
 * Description of CourseCategory
 *
 * @author Kaiste
 */
class CourseCategory implements ContentManipulator{
    private $id;
    private $name;
    private $description;
    private $image;
    private $amount;
    private $promotionAmount;
    private $status;
    private $installment = 0;
    private $firstInstallment;
    private $otherInstallment;
    private $tableName;
    private $dbObj;
    
    
    //Class constructor
    public function CourseCategory($dbObj, $tablePrefix='') {
        $this->tableName = $tablePrefix.'course_categories';
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
     * Method that adds a course category into the database
     * @return JSON JSON encoded string/result
     */
    function add(){ 
        $sql = "INSERT INTO $this->tableName (name, amount, promotion_amount, image, installment, first_installment, other_installment) VALUES ('{$this->name}','{$this->amount}','{$this->promotionAmount}','{$this->image}','{$this->installment}','{$this->firstInstallment}','{$this->otherInstallment}')";
        if($this->notEmpty($this->name,$this->amount)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, category successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding category! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a course category
     * @return JSON JSON encoded result
     */
    public function delete(){ 
        $sql = "DELETE FROM $this->tableName WHERE name = '$this->name' ";
        if($this->notEmpty($this->name)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, category successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting category! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches course categories from database for JQuery Data Table
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded coursecategory details
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
                $fetCatInstal = 'icon-eye-close'; $fetCatInstalCol = 'btn-warning'; $fetCatInstalTit = "Activate Installment Payment";
                if($r['installment'] == 1){  $fetCatInstal = 'icon-eye-open'; $fetCatInstalCol = 'btn-success'; $fetCatInstalTit = "De-activate Installment Payment";}
                $result[] = array($r['name'], utf8_encode('<img src="../media/category/'.utf8_encode($r['image']).'" width="60" height="50" style="width:60px; height:50px;" alt="Pix">'), utf8_encode($r['amount']), utf8_encode($r['promotion_amount']), utf8_encode($r['first_installment']), utf8_encode($r['other_installment']), utf8_encode(' <button data-name="'.$r['name'].'" data-promotion-amount="'.$r['promotion_amount'].'"  data-first-installment="'.$r['first_installment'].'"  data-other-installment="'.$r['other_installment'].'" data-amount="'.$r['amount'].'" data-image="'.$r['image'].'" class="btn btn-info btn-small edit-category"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> </button> <button data-name="'.$r['name'].'" data-image="'.$r['image'].'" class="btn btn-danger btn-small delete-category" title="Delete"><i class="btn-icon-only icon-trash"> </i></button> <button data-name="'.$r['name'].'" data-status="'.$r['status'].'"  class="btn '.$fetCourseRolCol.' btn-small activate-category"  title="'.$fetCourseRolTit.'"><i class="btn-icon-only '.$fetCourseStat.'"> </i></button> <button data-name="'.$r['name'].'" data-installment="'.$r['installment'].'"  class="btn '.$fetCatInstalCol.' btn-small activate-installment"  title="'.$fetCatInstalTit.'"><i class="btn-icon-only '.$fetCatInstal.'"> </i></button>'));
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches course categories from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @param Objec $dbObj None moodle database object
     * @return JSON JSON encoded coursecategory details
     */
    public function fetch($column="*", $condition="", $sort="id", $dbObj=null){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); $categoryName = ''; $categoryImage = ''; $categoryStatus = ''; $categoryAmount =''; $categoryPromoAmt = '';
        if(count($data)>0){
            foreach($data as $r){
                if($dbObj != null){
                    $categoryName = $r['name'];
                    $categoryStatus = CourseCategory::getSingle($dbObj, '', 'status', " name = '".$categoryName."'"); 
                    $categoryPromoAmt = CourseCategory::getSingle($dbObj, '', 'promotion_amount', " name = '".$categoryName."'");
                    $categoryAmount = CourseCategory::getSingle($dbObj, '', 'amount', " name = '".$categoryName."'");
                    $categoryImage = CourseCategory::getSingle($dbObj, '', 'image', " name = '".$categoryName."'");
                }
                $result[] = array("id" => $r['id'], "name" =>  utf8_encode($r['name']), "description" =>  utf8_encode(strip_tags($r['description'])), 'image' => utf8_encode($categoryImage), 'status' => utf8_encode($categoryStatus), 'status' => utf8_encode($categoryStatus), 'amount' => utf8_encode($categoryAmount), 'promotionAmount' => utf8_encode($categoryPromoAmt));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches course categories from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Courses category list
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
    
    /** Method that update single field detail of a course category
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $condition Condition
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $condition){ 
        $sql = "UPDATE course_categories SET $field = '{$value}' WHERE $condition ";
        if(!empty($condition)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, category successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating category! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);  
    }
    
    /** Method that update details of a course category
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $amount Course price
     * @param int $promotionAmount Promotional price
     * @param string $image Category image
     * @param int $firstInstallment First Installment plan amount
     * @param int $otherInstallment Other installments apart from first installment
     * @param string $categoryName Category name
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSpecial($dbObj, $amount, $promotionAmount, $image, $firstInstallment, $otherInstallment, $categoryName) { 
        $sql = "UPDATE course_categories SET amount = '{$amount}', promotion_amount = '{$promotionAmount}', image = '{$image}', first_installment = '{$firstInstallment}', other_installment = '{$otherInstallment}' WHERE name = '$categoryName' ";
        if(!empty($categoryName)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  category successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating  category! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** Method that update details of a course category
     * @return JSON JSON encoded success or failure message
     */
    public function update() { }
    
    /** getSingle() fetches a single column using $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $dbPrefix Database prefix
     * @param string $column Table's required column in the datatbase
     * @param int $condition Condition
     * @return string Name of the course
     */
    public static function getSingle($dbObj, $dbPrefix, $column, $condition) {
        $thisAsstReqVal = ''; $tableName = $dbPrefix.'course_categories';
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
        $tableName = $dbPrefix.'course_categories';
        $sql = "SELECT * FROM $tableName ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
}
