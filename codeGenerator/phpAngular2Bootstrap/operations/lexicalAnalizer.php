<?php
class LexicalAnalizer{
  // returns all the tockens in array format(this is the entry function)
  public function getTokens($s){
    $tokens = [];
    $s = $this->formatString($s);
    $s =  preg_replace("/,\d+\)/",")",$s);// remove multinumbers inside parenthesis separated by comma: (11,2)=>(11)
    $fieldArr = explode(",", $s);
    foreach ($fieldArr as $fa) {
      array_push($tokens,$this->structureData($fa));
    }
    return $tokens;
  }
  // remove unwanted strings. get the fields
  private function formatString($s){
    $sqlParts = "";
    $s =  preg_replace("/`|(\s\s)/","",$s);// remove ` and double space, new lines and tab...
    if(preg_match('/\(.*\)/',$s,$m)){
      $sqlParts = $m[0];
    }
    $sqlParts = substr(trim(preg_replace('!\s+!', ' ', $sqlParts)),1,strlen($sqlParts)-2);// get the fields
    $sqlParts = str_replace(", ", ",", trim($sqlParts));
    return $sqlParts;
  }
  // finite state machine
  private function structureData($s){
    /* values */
    $variableName = "";
    $dataType = "";
    $size = 0;
    $required = 0;
    $default = "";
    /* states */
    $s1 = 1;
    $s2 = 2;
    $s3 = 3;
    $s4 = 4;
    $s5 = 5;
    $s6 = 6;
    $s7 = 7;
    $end = 999;
    $state = $s1;
    foreach(explode(" ",$s) as $str){
      switch($state){
        case $s1 : {
          $variableName = $str;
          $state = $s2;
        }break;
        case $s2 : {
          $datatypeAndSize = explode("(",$str);
          if(sizeof($datatypeAndSize)>1){
            $dataType = $datatypeAndSize[0];
            $size = substr($datatypeAndSize[1],0,-1);
          }
          else{
            $dataType = $str;
          }
          $state = $s3;
        }break;
        case $s3 : {
          if($str=="NOT"){
            $state = $s4;
          }
          elseif($str=="DEFAULT"){
            $state = $s6;
          }
          else{
            $state = $end;
          }
        }break;
        case $s4 : {
          if($str=="NULL"){
            $state = $s5;
            $required = 1;
          }
        }break;
        case $s5 : {
          if($str=="DEFAULT"){
            $state = $s5;
          }
          else{
            $state = $end;
          }
        }break;
        case $s6 : {
          $default = $str;
          $state = $s7;
        }break;
        case $s7 : {
          $state = $end;
        }break;
        case $end : {
          $state = $end;
        }break;
      }
    }
    return array("variableName"=>$variableName,"dataType"=>$dataType,"size"=>$size,"required"=>$required,"default"=>$default);
  }
}
?>


