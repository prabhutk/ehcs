<?php

class Persistence
{                         
  private static $instance;   
  private $mysqli;

  public static function getInstance() 
  {
    if(!self::$instance) 
    { 
      self::$instance = new self(); 
    } 

    return self::$instance;
  }
  
  private function __construct() 
  {
    $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_LOGIN, DB_NAME);
  
    /* check connection */
    if($this->mysqli->connect_errno) 
    {
        Redirector::getInstance()->error(ERROR_CONNECTION);
    }
  }
  
  public function runSql($sql, $expectedRows = 1)
  {
    $result = $this->mysqli->query($sql);
    if($result === false)
    {
      Redirector::getInstance()->error(ERROR_DB_SQL); 
    }
    else
    {
        return $result;
    }
  }
  
  public function getAffectedRows()
  {
    return $this->mysqli->affected_rows; 
  }
  
  public function createHash($inText, $saltHash=NULL, $mode='sha1')
  { 
    // hash the text // 
    $textHash = hash($mode, $inText); 
    // set where salt will appear in hash // 
    $saltStart = strlen($inText); 
    // if no salt given create random one // 
    if($saltHash == NULL) { 
        $saltHash = hash($mode, uniqid(rand(), true)); 
    } 
    // add salt into text hash at pass length position and hash it // 
    if($saltStart > 0 && $saltStart < strlen($saltHash)) { 
        $textHashStart = substr($textHash,0,$saltStart); 
        $textHashEnd = substr($textHash,$saltStart,strlen($saltHash)); 
        $outHash = hash($mode, $textHashEnd.$saltHash.$textHashStart); 
    } elseif($saltStart > (strlen($saltHash)-1)) { 
        $outHash = hash($mode, $textHash.$saltHash); 
    } else { 
        $outHash = hash($mode, $saltHash.$textHash); 
    } 
    // put salt at front of hash // 
    $output = hash($mode, $saltHash.$outHash); 
    return $output; 
  } 
}
?>
