<?php
/**
 * Description of WebsiteContact
 *
 * @author Kaiste
 */
class WebsiteContact implements ContentManipulator{
    private $id;
    private $title;
    private $description;
    private $keywords;
    private $phone;
    private $email;
    private $address;
    private $dbObj;
    
    public function WebsiteContact($dbObj) {
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

    /** Method that fetches website contact page from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g website contact page_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded website contact page details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM website_contact ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM website_contact WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "title" => $r['title'], "description" => $r['description'], "keywords" => $r['keywords'], "phone" =>  utf8_encode($r['phone']), "email" =>  utf8_encode($r['email']), 'address' =>  utf8_encode($r['address']));
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
    
    /** Method that update single field detail of a website contact page
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE website_contact SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, website contact page successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating website contact page! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a website contact page
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE website_contact SET title = '{$this->title}', description = '{$this->description}', keywords = '{$this->keywords}', phone = '{$this->phone}', email = '{$this->email}', address = '{$this->address}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, website contact page successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating website contact page! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** getSingle() fetches a single column of a website contact page using the website contact page $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id WebsiteContact id of the website contact page whose name is to be fetched
     * @return string Name of the website contact page
     */
    public static function getSingle($dbObj, $column, $id) {
        $thisAsstReqVal = '';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM website_contact WHERE id = '{$id}' LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
}
