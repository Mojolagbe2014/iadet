<?php
/**
 * Description of WebsiteIndex
 *
 * @author Kaiste
 */
class WebsiteIndex implements ContentManipulator{
    private $id;
    private $title;
    private $description;
    private $keywords;
    private $topBackGround;
    private $topLogo;
    private $topH1;
    private $topH3;
    private $bottomBackGround;
    private $bottomH1;
    private $bottomH2;
    private $bottomVideo;
    private $dbObj;
    
    public function WebsiteIndex($dbObj) {
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

    /** Method that fetches website indexs from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g website index_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded website index details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM website_index ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM website_index WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "title" => $r['title'], "description" => $r['description'], "keywords" => $r['keywords'], "topBackGround" =>  utf8_encode($r['top_slider_background']), "topLogo" =>  utf8_encode($r['top_slider_logo']), 'topH1' =>  utf8_encode($r['top_slider_h1']), 'topH3' => utf8_encode($r['top_slider_h3']), 'bottomBackGround' =>  utf8_encode($r['bottom_slider_background']), 'bottomH1' =>  utf8_encode($r['bottom_slider_h1']), 'bottomH2' =>  utf8_encode($r['bottom_slider_h2']), 'bottomVideo' =>  utf8_encode($r['bottom_slider_video']));
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
    
    /** Method that update single field detail of a website index
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE website_index SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, website index successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating website index! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a website index
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE website_index SET title = '{$this->title}', description = '{$this->description}', keywords = '{$this->keywords}', top_slider_background = '{$this->topBackGround}', top_slider_logo = '{$this->topLogo}', top_slider_h1 = '{$this->topH1}', top_slider_h3 = '{$this->topH3}', bottom_slider_background = '{$this->bottomBackGround}', bottom_slider_h1 = '{$this->bottomH1}', bottom_slider_h2 = '{$this->bottomH2}', bottom_slider_video = '{$this->bottomVideo}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, website index successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating website index! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** getSingle() fetches the title of an website index using the website index $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id WebsiteIndex id of the website index whose name is to be fetched
     * @return string Name of the website index
     */
    public static function getSingle($dbObj, $column, $id) {
        $thisAsstReqVal = '';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM website_index WHERE id = '{$id}' LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
}
