<?php

Class Query extends Connection{
     
 
      public function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return  $data;
    }


       protected function executeQuery($sql){
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $row=$stmt->fetchAll();
        return $row;
      }

      protected function executeRow($sql, $params=array()){
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        $row=$stmt->fetch();
        if($row!==false){
          return $row;
        } else {
          return false;
        }
      }
}