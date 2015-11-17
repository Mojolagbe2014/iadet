<?php
/**
 * Description of WebsiteAbout
 *
 * @author Kaiste
 */
class WebsiteAbout implements ContentManipulator{
    private $id;
    private $title;
    private $description;
    private $keywords;
    private $contentHeader;
    private $content;
    private $dbObj;
    
    public function WebsiteAbout($dbObj) {
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

    public function add() {
        
    }

    public function delete() {
        
    }

    /** Method that fetches website about page from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g website about page_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded website about page details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM website_about ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM website_about WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "title" => $r['title'], "description" => $r['description'], "keywords" => $r['keywords'], "contentHeader" =>  utf8_encode($r['content_header']), "content" =>  utf8_encode($r['content']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
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
    
    /** Method that update single field detail of a website about page
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE website_about SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, website about page successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating website about page! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a website about page
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE website_about SET title = '{$this->title}', description = '{$this->description}', keywords = '{$this->keywords}', content_header = '{$this->contentHeader}', content = '{$this->content}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, website about page successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating website about page! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** getSingle() fetches the title of an website about page using the website about page $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id WebsiteAbout id of the website about page whose name is to be fetched
     * @return string Name of the website about page
     */
    public static function getSingle($dbObj, $column, $id) {
        $thisAsstReqVal = '';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM website_about WHERE id = '{$id}' LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
}
