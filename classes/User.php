<?php
/**
 * Description of User
 *
 * @author Kaiste
 */
class User implements ContentManipulator{
    protected $id;
    private $auth = 'manual';
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $city;
    protected $country;
    protected $description;
    protected $picture;
    protected $website;
    protected $skypeId;
    protected $yahooId;
    protected $phone;
    protected $address;
    protected $userName;
    protected $passWord;
    protected $dateRegistered;
    protected $confirmed = 1;
    protected $mNetHostId = 1;
    protected $facebookId;
    protected $twitterId;
    private $tableName; 
    protected $dbObj;
    
    
    //Class constructor
    public function User($dbObj, $tablePrefix='') {
        $this->tableName = $tablePrefix.'user';
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
     * Method that adds a user into the database
     * @return JSON JSON encoded string/result
     */
    function add(){
        $sql = "INSERT INTO $this->tableName (auth, confirmed, mnethostid, username, password, firstname, lastname, email, phone1, address, timecreated) "
                ."VALUES ('{$this->auth}','{$this->confirmed}','{$this->mNetHostId}','".strtolower($this->userName)."','".password_hash($this->passWord, 1, array('cost' => 10))."','{$this->firstName}','{$this->lastName}','{$this->email}','{$this->phone}','{$this->address}','{$this->dateRegistered}')";
        
        if(!$this->emailExists()){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding user! ".  mysqli_error($this->dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Email already exist in our database. Please change the email or retrieve old account if you are the owner of the email."); }
        
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a user
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM $this->tableName WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting user! ".  mysqli_error($this->dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** emailExists checks if an email truely exists in the database
     * @return Boolean True for exists, while false for not
     */
    public function emailExists(){//password_verify($password, $hash)
        $sql =  "SELECT * FROM $this->tableName WHERE email = '$this->email' LIMIT 1 ";
        $storedEmail = '';
        $results = $this->dbObj->fetchAssoc($sql);
        foreach ($results as $result) {
            $storedEmail = $result['email'];
        }
        if($this->email == $storedEmail){ return true; }
        else{ return false;    }
    } 
    
    /** Method that fetches users from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @param Object $filesObj Instance of Files class
     * @return JSON JSON encoded user details
     */
    public function fetch($column="*", $condition="", $sort="id", $filesObj=null){
        $sql = "SELECT $column FROM $this->tableName ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM $this->tableName WHERE $condition ORDER BY $sort";}
        $data = $this->dbObj->fetchAssoc($sql);
        $result =array(); $userPicture = '';
        if(count($data)>0){
            foreach($data as $r){
                $userPicture = $r['picture'];
                if($filesObj !=null){ $userPicture = User::getPicture($filesObj, $r['picture'], $r['id']); }
                $result[] = array("id" => $r['id'], "firstName" =>  utf8_encode($r['firstname']), "lastName" =>  utf8_encode($r['lastname']), 'email' =>  utf8_encode($r['email']), 'description' =>  utf8_encode($r['description']), 'picture' =>  utf8_encode($userPicture), 'phone' =>  utf8_encode($r['phone1']), 'address' =>  utf8_encode($r['address']), 'userName' =>  utf8_encode($r['username']), 'passWord' =>  $r['password'], 'dateRegistered' =>  utf8_encode($r['timecreated']), 'status' => $r['confirmed']);
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error($this->dbObj->connection)); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** getPicture() fetches a user's picture
     * @param Object $filesObj Instance of Files Class
     * @param int $pictureId Picture id located at picture column of user table
     * @param int $userId User id
     * @return string Link to user's picture
     */
    public static function getPicture($filesObj, $pictureId, $userId){
        $userPicture = '';
        foreach ($filesObj->fetchRaw("*", " id = $pictureId ", "id LIMIT 1 ") as $picture) {
            $userPicture = MOODLE_URL.'pluginfile.php/'.$picture['contextid'].'/user/icon/'.$picture['filearea'].'/clean/'.$picture['filename'].'?rev='.$userId;  
        } 
        return $userPicture;
    }
    
    /** Method that fetches users from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array User list
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
    
    /** Method that update single field detail of a user
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE $this->tableName SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating user! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a user
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE $this->tableName SET firstname = '{$this->firstName}', lastname = '{$this->lastName}', phone1 = '{$this->phone}', address = '{$this->address}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating user! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** Change Password
     * @param string $newPassword New password
     * @return JSON JSON Object success or failure
     */
    public function changePassword($newPassword){
        $sql = "UPDATE $this->tableName SET password = '".password_hash($newPassword, 1, array('cost' => 10))."' WHERE id = $this->id ";
        $pwdExists = $this->pwdExists();//Check if old password is corect
        if($pwdExists==TRUE){
            $result = $this->dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, user password successfully updated!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating user password! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Old password you typed is incorrect. Please retype old password."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
     /** Reset Password
     * @return JSON JSON Object success or failure
     */
    public function resetPassword(){
        $sql = "UPDATE $this->tableName SET password = '".password_hash($this->passWord, 1, array('cost' => 10))."' WHERE email = '$this->email' ";
        if($this->notEmpty($this->passWord, $this->email)){
            $result = $this->dbObj->query($sql);
            if($result != false){ $json = array("status" => 1, "msg" => "Done, user password successfully reset!"); }
            else{ $json = array("status" => 2, "msg" => "Error reseting user password! ".  mysqli_error($this->dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Supply your email."); }
        $this->dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** pwdExists checks if a password truely exists in the database
     * @return Boolean True for exists, while false for not
     */
    public function pwdExists(){//password_verify($password, $hash)
        $sql =  "SELECT * FROM $this->tableName WHERE id = $this->id LIMIT 1 ";
        $hashedPassword = '';
        $results = $this->dbObj->fetchAssoc($sql);
        foreach ($results as $result) {
            $hashedPassword = $result['password'];
        }
        if(password_verify($this->passWord, $hashedPassword)){ return true; }
        else{ return false;    }
    } 
    
    /**
     * Method that returns count/total number of a particular user
     * @param Object $dbObj Datatbase connectivity object
     * @param string $dbPrefix Database table prefix
     * @return int Number of users
     */
    public static function getRawCount($dbObj, $dbPrefix){
        $tableName = $dbPrefix.'user';
        $sql = "SELECT * FROM $tableName ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
    
    /** getSingle() fetches the column using $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id User id of the User
     * @return string Column value
     */
    public static function getSingle($dbObj, $dbPrefix, $column, $id){
        $tableName = $dbPrefix.'user';
        $thisUserReqVal = '';
        $thisUserReqVals = $dbObj->fetchNum("SELECT $column FROM $tableName WHERE id = '{$id}' ");
        foreach ($thisUserReqVals as $thisUserReqVals) { $thisUserReqVal = $thisUserReqVals[0]; }
        return $thisUserReqVal;
    }
    
    /**  
     * Method that enrols for a course
     * @param Object $dbMoObj Database connectivity and manipulation object
     * @param string $dbPrefix Database prefix
     * @param int $user User Id
     * @param datetime $timeStart Start time
     */
    public static function enrol($dbMoObj, $dbPrefix, $user, $timeStart, $modifierId, $timeCreated, $timeModified, $course){
        $tableName = $dbPrefix.'user_enrolments'; $enrolTable = $dbPrefix.'enrol';
        
        $enrolResult = $dbMoObj->fetchAssoc("SELECT * FROM $enrolTable WHERE courseid = $course AND enrol='manual' LIMIT 1");
        foreach ($enrolResult as $enrolResult){
            $sql = "INSERT INTO $tableName (enrolid, userid, timestart, modifierid, timecreated, timemodified) "
                ."VALUES ('{$enrolResult['id']}','{$user}','{$timeStart}','".$modifierId."','".$timeCreated."','{$timeModified}')";
            if(count($dbMoObj->fetchAssoc("SELECT * FROM $tableName WHERE userid = $user AND enrolid = '{$enrolResult['id']}' ")) < 1){
                $result = $dbMoObj->query($sql);
            }
        }
    }
    
    /**  
     * Method that enrols for a course category
     * @param Object $dbMoObj Database connectivity and manipulation object
     * @param string $dbPrefix Database prefix
     * @param int $user User Id
     * @param datetime $timeStart Start time
     * @param int $modifierId Modifier Id
     * @param datetime $timeCreated Time created
     * @param datetime $timeModified Time Modified
     * @param int $category Catgory Id
     */
    public static function enrolCategory($dbMoObj, $dbPrefix, $user, $timeStart, $modifierId, $timeCreated, $timeModified, $category){
        $tableName = $dbPrefix.'user_enrolments'; $enrolTable = $dbPrefix.'enrol'; $courseTable = $dbPrefix.'course'; $categoryTable = $dbPrefix.'course_categories';
        
        if($category !=0){
            $enrolCatResult = $dbMoObj->fetchAssoc("SELECT * FROM $courseTable WHERE category = $category AND format !='site' ");
            foreach ($enrolCatResult as $courseDet){
                $enrolResult = $dbMoObj->fetchAssoc("SELECT * FROM $enrolTable WHERE courseid = ".$courseDet['id']." AND enrol='manual' LIMIT 1");
                foreach ($enrolResult as $enrolResult){
                    $sql = "INSERT INTO $tableName (enrolid, userid, timestart, modifierid, timecreated, timemodified) "
                        ."VALUES ('{$enrolResult['id']}','{$user}','{$timeStart}','".$modifierId."','".$timeCreated."','{$timeModified}')";
                    if(count($dbMoObj->fetchAssoc("SELECT * FROM $tableName WHERE userid = $user AND enrolid = '{$enrolResult['id']}' ")) < 1){
                        $result = $dbMoObj->query($sql);
                    }
                }
            }
            $catDetails = $dbMoObj->fetchAssoc("SELECT * FROM $categoryTable WHERE parent = $category ");
            foreach ($catDetails as $catDetail){
                User::enrolCategory($dbMoObj, $dbPrefix, $user, $timeStart, $modifierId, $timeCreated, $timeModified, $catDetail['id']);
            }
        }
    }
}
