<?php
 Class Paciente extends Query{


public function alreadyIn($dni){
    $sql ="SELECT * FROM pacientes WHERE dni = ?;";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$dni]);
    $row = $stmt->fetch();
    return $row;
}

public function searchPacienteBynName($nombre){
  $sql = "SELECT * FROM pacientes WHERE nombre = ?";
  $stmt = $this->connect()->prepare($sql);
  $stmt->execute([$nombre]);
  $row = $stmt->fetchAll();
  return $row;
}


public function insertar($nombre, $apellido, $telefono, $dni, $correo, $edad, $clave){
   if($this->correoValido($correo) === false || $this->selectPaciente($correo)){
    //Si el correo no es válido o si el paciente ya existe
    return false;
   }else{
    $passwordHash = password_hash($clave, PASSWORD_DEFAULT);
    $sql = "INSERT into pacientes (nombre, apellido, telefono, dni, correo, edad, clave) VALUES(?,?,?,?,?,?,?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$nombre, $apellido, $telefono, $dni, $correo, $edad, $passwordHash]);
    return true;
   }
}

public function logIn($correo, $clave){
    $row = $this->selectPaciente($correo);
    //Esto para ver si existe
    if ($row==false) {
        return false;
    } else {
        return password_verify($clave, $row['clave']);
    }
  }

  
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return  $data;
}
    function correoValido($correo){
    return filter_var($correo, FILTER_VALIDATE_EMAIL);
    }

    public function selectPaciente($correo){
        $sql = "SELECT * FROM pacientes WHERE correo = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$correo]);
        $row=$stmt->fetch();
        if($row!==false)
        {return $row;
        } else {
          return false;}
        
      }

      function cambioClave($correo, $clave){
        $existe = $this->selectPaciente($correo);
        if($existe){
          $claveNueva = password_hash($clave, PASSWORD_DEFAULT);
          $sql = 'UPDATE pacientes SET clave = ? WHERE correo = ?';
          $stmt = $this->connect()->prepare($sql);
          $stmt->execute([$claveNueva, $correo]);
          $row = $stmt->fetch();
          return $row;
        }
      }

      public function selectCorreoPacientes() {
        $sql = "SELECT correo FROM pacientes";
        $stmt = $this->connect()->prepare( $sql );
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $correosRegistrados = [];
        foreach ($rows as $row) {
          $correosRegistrados[] = $row['correo'];
        }
        return $correosRegistrados;
      }

      public function getIdPaciente($correo){
        $sql = 'SELECT * FROM pacientes WHERE correo = ?';
        $row = $this->executeRow($sql, [$correo]);
        if ($row) {
          return $row['id_paciente'];
        } else {
          return null;}
      }

      public function printPacientes(){
        $sql ="SELECT id_paciente, nombre, apellido, telefono, dni, correo FROM pacientes";
        return $this->executeQuery($sql);
      }
}

