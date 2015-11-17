<?php
/**
 * Description of Assessment
 *
 * @author Kaiste
 */
class Assessment implements ContentManipulator{
    private $id;
    private $lesson;
    private $question;
    private $title;
    private $mark;
    private $submissionDate;
    private $dateAdded = " CURRENT_DATE ";
    private $attachment;
    private $status = 0;
    private $dbObj;
    
    
    //Class constructor
    public function Assessment($dbObj) {
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
     * Method that adds an assessment into the database
     * @return JSON JSON encoded result
     */
    public function add(){
        $sql = "INSERT INTO assessment (lesson, title, question, mark, submission_date, date_added, attachment, status) "
                ."VALUES ('{$this->lesson}','{$this->title}','{$this->question}','{$this->mark}','{$this->submissionDate}',$this->dateAdded,'{$this->attachment}','{$this->status}')";
        if($this->notEmpty($this->lesson,$this->question,$this->submissionDate)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, assessment successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding assessment! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting an assessment
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM assessment WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, assessment successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting assessment! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches assessments from database for JQuery Data Table
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g assessment_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded assessment details
     */
    public function fetchForJQDT($draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM assessment ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM assessment WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); $fetAssessmentStat = 'icon-check-empty'; $fetAssessmentRolCol = 'btn-warning'; $fetAssessmentRolTit = "Activate Assessment";
        if(count($data)>0){
            foreach($data as $r){ 
                $attachmentLink = "No Attachment";
                $fetAssessmentStat = 'icon-check-empty'; $fetAssessmentRolCol = 'btn-warning'; $fetAssessmentRolTit = "Activate Assessment";
                if($r['status'] == 1){  $fetAssessmentStat = 'icon-check'; $fetAssessmentRolCol = 'btn-success'; $fetAssessmentRolTit = "De-activate Assessment";}
                if(!empty($r['attachment'])) $attachmentLink = '<a href="'.SITE_URL.'media/assessment/'.$r['attachment'].'">View Attachment</a>';
                $result[] = array($r['id'], utf8_encode(' <button data-id="'.$r['id'].'" data-lesson="'.$r['lesson'].'" data-title="'.$r['title'].'" data-mark="'.$r['mark'].'" data-submission-date="'.$r['submission_date'].'" data-date-added="'.$r['date_added'].'" data-attachment="'.$r['attachment'].'" class="btn btn-info btn-small edit-assessment"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span id ="JQDTquestionholder" class="hidden">'.$r['question'].'</span></button> <button data-id="'.$r['id'].'" data-status="'.$r['status'].'" data-title="'.$r['title'].'"  class="btn '.$fetAssessmentRolCol.' btn-small activate-assessment"  title="'.$fetAssessmentRolTit.'"><i class="btn-icon-only '.$fetAssessmentStat.'"> </i></button> <button data-id="'.$r['id'].'" data-tite="'.$r['attachment'].'" data-attachment="'.$r['attachment'].'" class="btn btn-danger btn-small delete-assessment" title="Delete"><i class="btn-icon-only icon-trash"> </i></button>'), utf8_encode(Lesson::getTitle($this->dbObj, $r['lesson'])), utf8_encode($r['title']), StringManipulator::trimStringToFullWord(90, utf8_encode(stripslashes(strip_tags($r['question'])))), utf8_encode($r['mark']), utf8_encode($r['submission_date']), utf8_encode($attachmentLink), utf8_encode($r['date_added']));//
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error($this->dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        $this->dbObj->close();
        //header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches assessments from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g assessment_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded assessment details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM assessment ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM assessment WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "lesson" =>  utf8_encode($r['lesson']), "question" =>  utf8_encode($r['question']), 'title' =>  utf8_encode($r['title']), 'mark' => utf8_encode($r['mark']), 'submissionDate' =>  utf8_encode($r['submission_date']), 'dateAdded' =>  utf8_encode($r['date_added']), 'attachment' =>  utf8_encode($r['attachment']), 'status' =>  utf8_encode($r['status']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches assessment from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Assessment list
     */
    public function fetchRaw($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM assessment ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM assessment WHERE $condition ORDER BY $sort";}
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
    
    /** Method that update single field detail of an assessment
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE assessment SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, assessment successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating assessment! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of an assessment
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE assessment SET lesson = '{$this->lesson}', title = '{$this->title}', question = '{$this->question}', mark = '{$this->mark}', submission_date = '{$this->submissionDate}', attachment = '{$this->attachment}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, assessment successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating assessment! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }
    
    /** getSingle() fetches the title of an assessment using the assessment $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id Assessment id of the assessment whose name is to be fetched
     * @return string Name of the assessment
     */
    public static function getSingle($dbObj, $column, $id) {
        $thisAsstReqVal = '';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM assessment WHERE id = '{$id}' LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
    
    /**
     * fetchAsChildren fetches assessment where $id is true
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $id Lesson id of the assessment whose names are to be fetched
     * @return JSON Array title of the assessments
     */
    public static function fetchAsChildren($dbObj, $id) {
        $result = array(); 
        $data = $dbObj->fetchAssoc("SELECT * FROM assessment WHERE lesson = $id ");
        foreach ($data as $r) { 
            $result[] = array('title'=> $r['title']);
        }
        return $result;
    }

}
