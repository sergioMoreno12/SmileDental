<?php
Class Dentist extends Query{
     
     public function insertaDentist($nombre, $apellido, $dni, $colegiado, $correo, $clave, $telefono, $especialidad){
        if($this->alreadyIn($dni)){
            return false;
        }else{
             $date = date("Y-m-d");
             $password = password_hash($clave, PASSWORD_DEFAULT);
             $sql = "INSERT INTO dentist(nombre, apellido, dni, nro_colegiado, correo, clave, telefono, especialidad, fecha_alta) VALUES(?,?,?,?,?,?,?,?,?)";
             $stmt = $this->connect()->prepare($sql);
             $stmt->execute([$nombre, $apellido, $dni, $colegiado, $correo, $password, $telefono, $especialidad, $date]);
        }    
     }


     public function update($dni, $campo, $valor) {
        
            $sql = "UPDATE dentist SET $campo = ? WHERE dni = ?";
            $stmt = $this->connect()->prepare($sql);
            if($stmt->execute([$valor, $dni])){ // Swap $campo and $valor
            return true;
            }else {
                var_dump($stmt->errorInfo());
            return false;}
    }
    

     public function deleteDentist($dni) {
        if (!$this->alreadyIn($dni)) {
            echo "<script> alert('El dentista con DNI $dni no existe')</script>";
            return false;
        }else{
        $sql = "DELETE FROM dentist WHERE dni = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$dni]);
        return true;
        }
    }

   
     public function insertBaja($dni) {
        $sql = "INSERT INTO baja_dentistas (id_odontologo, nombre, apellido, dni, fecha_baja) VALUES (?,?,?,?,?);";
        $stmt = $this->connect()->prepare($sql);
        $row = $this->alreadyIn($dni);
    
        if (is_array($row)) {
            $id = $row['id_odontologo'];
            $nombre = $row['nombre'];
            $apellido = $row['apellido'];
            $thisDate = date("Y-m-d");
    
            try {
                $stmt->execute([$id, $nombre, $apellido, $dni, $thisDate]);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        } else {

            return false;
        }
    
        return true;
    }
    
    
    public function alreadyIn($dni){
        $sql ="SELECT * FROM dentist WHERE dni = ?;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$dni]);
        $row = $stmt->fetch();
        return $row;
    }

    public function getId($dni){
        $sql = "SELECT id_odontologo FROM dentist WHERE dni=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$dni]);
         $row=$stmt->fetch();
      
         if ($row) {
          return $row['id_odontologo'];
      } else {
          return null; 
      }
    }

    
    public function selectByDni($dni){
        $sql = "SELECT * FROM dentist WHERE dni = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$dni]);
         $row=$stmt->fetch();
        return $row;
      }

      public function selectDentist($correo){
        $sql = "SELECT * FROM dentist WHERE correo = ?";
        return $this->executeRow($sql, [$correo]);
      }

      public function printDentist(){
        $sql ="SELECT id_odontologo, nombre, apellido, dni, nro_colegiado, telefono, especialidad, fecha_alta FROM dentist";
        return $this->executeQuery($sql);
       }

       public function getIdGeneral(){
        $sql = 'SELECT id_odontologo FROM general';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $row=$stmt->fetchAll(PDO::FETCH_COLUMN);
        return $row;
       }


      public function printDentistBaja(){
        $sql ="SELECT id_odontologo, nombre, apellido, dni, fecha_baja FROM baja_dentistas";
        return $this->executeQuery($sql);
      }
 
}