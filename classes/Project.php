<?php
/* 
 * Class Project describes individual students' projects
 * 
 */
class Project implements ContentManipulator{
    //class properties/data
    private $id;
    private $title;
    private $abstract;
    private $author;
    private $matricNumber;
    private $email;
    private $category;
    private $department;
    private $supervisor;
    private $year;
    private $projectFile;
    private $dateUploaded = " CURRENT_DATE ";
    private $status = 0;
    private $dbObj;

    
    public function __construct($dbObj) {
        $this->dbObj =  $dbObj;
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
     * Method that submits a project into the database
     */
    function add(){
        $sql = "INSERT INTO project (title, abstract, author, matric_number, email, category, department, supervisor, year, project_file, date_uploaded, status) "
                ."VALUES ('{$this->title}','{$this->abstract}','{$this->author}','{$this->matricNumber}','{$this->email}','{$this->category}','{$this->department}','{$this->supervisor}','{$this->year}','{$this->projectFile}',$this->dateUploaded,'{$this->status}')";
        if($this->notEmpty($this->title,$this->abstract,$this->category,$this->projectFile,$this->matricNumber)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, project successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding project! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a project
     */
    public function delete(){
        $sql = "DELETE FROM project WHERE id = $this->id AND supervisor LIKE '".$this->supervisor."' ";
        if($this->notEmpty($this->id,$this->supervisor)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, project successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting project! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches projects from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM project ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM project WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "title" =>  utf8_encode($r['title']), 'author' =>  utf8_encode($r['author']), 'abstract' => trim(strip_tags(utf8_encode($r['abstract'])), 35), 'matricNumber' =>  utf8_encode($r['matric_number']), 'email' =>  utf8_encode($r['email']), 'category' =>  utf8_encode($r['category']), 'department' =>  utf8_encode($r['department']), 'supervisor' =>  utf8_encode($r['supervisor']), 'year' => utf8_encode($r['year']), 'projectFile' =>  utf8_encode($r['project_file']), 'dateUploaded' =>  utf8_encode($r['date_uploaded']), 'status' => $r['status']);
            }
            $json = array("status" => 1, "info" => $result);
        } else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error($this->dbObj->connection)); }
        
        $this->dbObj->close();
        header('Content-type: application/json');
        echo json_encode($json);
    }
    
    /** Method that fetches projects from database for supervisor's approval
     */
//    public function fetchForSupervisor(){
//        $sql = "SELECT * FROM project WHERE supervisor = '".$this->supervisor."' AND department = '" .$this->department."' AND status = 0 ORDER BY date_uploaded";
//        $data = $this->dbObj->fetchAssoc($sql);
//        $result =array(); 
//        if(count($data)>0){
//            foreach($data as $r){
//                $result[] = array("id" => $r['id'], "title" =>  utf8_encode($r['title']), 'author' =>  utf8_encode($r['author']), 'abstract' => trim(strip_tags(utf8_encode($r['abstract'])), 35), 'matricNumber' =>  utf8_encode($r['matric_number']), 'email' =>  utf8_encode($r['email']), 'category' =>  utf8_encode($r['category']), 'department' =>  utf8_encode($r['department']), 'supervisor' =>  utf8_encode($r['supervisor']), 'year' => utf8_encode($r['year']), 'projectFile' =>  utf8_encode($r['project_file']), 'dateUploaded' =>  utf8_encode($r['date_uploaded']), 'status' => $r['status']);
//            }
//            $json = array("status" => 1, "info" => $result);
//        } else{ $json = array("status" => 2, "msg" => $this->supervisor.mysqli_error($this->dbObj->connection)); }
//        
//        $this->dbObj->close();
//        header('Content-type: application/json');
//        echo json_encode($json);
//    }

    public function update() {
        
    }
    
    /** Method that update single field detail of a project
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE project SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, project successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating project! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        echo json_encode($json);
    }
    
    /** Empty string checker  */
    public function notEmpty() {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) { return false; } 
            else {continue; }
        }
        return true;
    }

    
}