<?php

session_start();
class Chatbot {

  private $dbConnection;

  private $_dbHost = 'localhost';
  
  private $_dbUsername = 'root';
  
  private $_dbPassword = 'webonise123#';
  
  public $_databaseName = 'blog';
  
  public function __construct() {
    $this->dbConnection = new mysqli($this->_dbHost, $this->_dbUsername, 
        $this->_dbPassword, $this->_databaseName);

    if ($this->dbConnection->connect_error) {
      die('Connection error.');
    }
  }

  /** 
   * @return array
   */
  public function getMessages() {
 
    $messages = array();
    $id2= $_SESSION['id2'];
    $id= $_SESSION['id'];
    $query = <<<QUERY
        SELECT 
          `chat`.`message`, 
          `chat`.`sent_on`,
          `chat`.`seen`,
          `chat`.`user_id`,
          `chat`.`user2_id`,
          `users`.`id`, 
          `chat`.`name`,
          `users`.`image`
        FROM `users`
        INNER JOIN `chat`
        ON `chat`.`user_id` = `users`.`id`
        ORDER BY `sent_on`
QUERY;
//     $query = <<<QUERY
//         SELECT 
//           `chat`.`message`, 
//           `chat`.`sent_on`,
//           `chat`.`seen`,
//           `chat`.`user_id`,
//           `chat`.`user2_id`,
//           `chat`.`name`
//         FROM `chat`
//         ORDER BY `sent_on`
// QUERY;

    $resultObj = $this->dbConnection->query($query);

    while ($row = $resultObj->fetch_assoc()) {
      $messages[] = $row;
    }

    return $messages;
  }
  public function getUserMessages() {
    $userId = (int) $_SESSION['id'];

    $null=0;
    $messages = array();
    $query = <<<QUERY
        SELECT 
          `chat`.`message`, 
          `chat`.`sent_on`,
          `chat`.`seen`,

          `users`.`id`, 
          `chat`.`user_id`,
          `chat`.`user2_id`,
          `users`.`name`,
          `users`.`email`,
          `users`.`image`
        FROM `users`
        JOIN `chat`
          ON `chat`.`user_id` = `users`.`id`
          AND `chat`.`user_id` != $userId
          AND `chat`.`seen` = $null
          AND `chat`.`user2_id` = $userId
        ORDER BY `sent_on`
QUERY;
    
   
    $resultObj = $this->dbConnection->query($query);

    while ($row = $resultObj->fetch_assoc()) {
      $messages[] = $row;
    }
    
    return $messages;
  }


  public function addMessage($userId, $user2Id,$name, $msg ){
    $addResult = false;
    
    $cUserId = (int) $userId;
    $cUser2Id = (int) $user2Id;
    $cMessage = $this->dbConnection->real_escape_string($msg);
    
    $query = <<<QUERY
      INSERT INTO `chat` (`user_id`,`user2_id`,`name`,`message`, `sent_on`)
      VALUES ({$cUserId}, {$cUser2Id},'{$name}','{$cMessage}', UNIX_TIMESTAMP())
QUERY;

    $result = $this->dbConnection->query($query);
    
    if ($result !== false) {
    
      $addResult = $this->dbConnection->insert_id;
    }
     else {
      echo $this->dbConnection->error;
    }
    
    return $addResult;
  }


public function sendRequest($mainId,$userId)
{
  $query = <<<QUERY
      INSERT INTO `follow` (`user_id`,`following`)
      VALUES ({$mainId}, {$userId})
QUERY;

     $result = $this->dbConnection->query($query);
     if ($result !== false && $result2 !== false) {
     
      $addResult = $this->dbConnection->insert_id;
    }
     else {
       
      echo $this->dbConnection->error;
    }
   
    return $addResult;
  }



  public function getRequest()
  {
    $followers = array();
    $query = <<<QUERY
        SELECT 
          `follow`.`user_id`, 
          `follow`.`following`,
          `users`.`id`, 
          `users`.`name`,
          `users`.`image`
        FROM `users`
        INNER JOIN `follow`
        ON `follow`.`user_id` = `users`.`id`
      
     
QUERY;

    $resultObj = $this->dbConnection->query($query);
   
    while ($row = $resultObj->fetch_assoc()) {
      $followers[] = $row;
    }

    return $followers;
  }
  public function sendUnfollowRequest($mainId,$userId)
  {
    $followers = array();
    $query = <<<QUERY
        DELETE FROM `follow`
        WHERE user_id = $mainId
        AND following = $userId
     
QUERY;

    $resultObj = $this->dbConnection->query($query);
   
  }
  public function getUserFollowing()
  {
    $following = array();
    $id= $_SESSION['id'];
    $query = <<<QUERY
        SELECT 
          `follow`.`user_id`, 
          `follow`.`following`,
          `users`.`id`, 
          `users`.`name`,
          `users`.`image`
        FROM `users`
        INNER JOIN `follow`
        ON `follow`.`following` = `users`.`id`
     
QUERY;

    $resultObj = $this->dbConnection->query($query);
   
    while ($row = $resultObj->fetch_assoc()) {
      $following[] = $row;
    }

    return $following;
  }
  public function getUserById($id)
  {
    // $credentials = array();
    $query = <<<QUERY
        SELECT 
        *
        FROM `users`
        WHERE id = $id 
       
QUERY;

    $resultObj = $this->dbConnection->query($query);
    
    while ($row = $resultObj->fetch_assoc()) {
      $credentials= $row;
    }

    return $credentials;
   
  }
}