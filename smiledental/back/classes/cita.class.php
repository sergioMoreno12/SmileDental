<?php
Class Cita extends Query{

    public function getDisponibildad($fecha){
        $sql = 'SELECT * FROM citas WHERE fecha = ?';
        $stmt = $this->connect()->prepare($sql);  
        $stmt->execute([$fecha]);
        $row=$stmt->fetchAll();
        return $row;
       }

       public function revisaCitas($fecha, $hora){
        $sql = 'SELECT * FROM citas WHERE fecha = ? AND hora = ?';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fecha, $hora]);
        $row=$stmt->fetchAll();
        return $row;
       }

       public function tieneCitaGeneral($id){
        $sql = 'SELECT * FROM citas WHERE id_paciente = ?';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $row=$stmt->fetchAll();
        return $row;
       }

       public function historicoCitas($id){
        $sql = 'SELECT * FROM citas WHERE id_dentista = ? and fecha < ?';
        $fecha = date('Y-m-d');
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $fecha]);
        $row=$stmt->fetchAll();
        return $row;
       }
       
      
       public function fechaCitasId($id, $hoy){
        $sql = 'SELECT * FROM citas WHERE id_paciente = ? AND fecha > ?';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id, $hoy]);
        $row=$stmt->fetch();
        return $row;
       }

       
   public function fechaCitasDent($id, $hoy){
    $sql = 'SELECT * FROM citas WHERE id_dentista = ? AND fecha > ?';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id, $hoy]);
    $row=$stmt->fetchAll();
    return $row;
   }


   public function insertCita($id_paciente,$id_dentista, $fecha, $hora){
    $sql = 'INSERT INTO citas(id_paciente, id_dentista, fecha, hora) VALUES (?,?,?,?)';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id_paciente, $id_dentista, $fecha, $hora]);
    return true;
   }

   public function updateDocs($id, $texto, $fileName, $fileContent){
    $sql = "INSERT INTO historia (id_cita, historia, archivo) VALUES (?,?,?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id,$texto, $fileContent]);
    return true;
 }

 public function selectAllFromCitas($id){
    $sql ="SELECT archivo FROM historia WHERE id_cita=?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id]);
    $row=$stmt->fetch();
    return $row;
 }


public function getHorasDisponibles($fecha){
      $sql = 'SELECT DISTINCT hora FROM citas WHERE fecha = ?';
      $stmt = $this->connect()->prepare($sql);
     $stmt->execute([$fecha]);
     $horasOcupadas = $stmt->fetchAll(PDO::FETCH_COLUMN);
      $horasTotales = range(8, 20);
      $horasDisponibles = array_diff($horasTotales, $horasOcupadas);
      return $horasDisponibles;
 }

public function getFecha($id_paciente){
    $sql = 'SELECT MAX(fecha) AS fecha_reciente FROM citas WHERE id_paciente = ?';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id_paciente]);
    $row=$stmt->fetch();
    return $row['fecha_reciente'];
  }
  
  public function borrarCita($id_cita){
    $sql = 'DELETE FROM citas WHERE id_cita = :id';
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':id', $id_cita, PDO::PARAM_INT);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
  }

   function buscaCitaEspecialista($id, $fecha){
    $sql = 'SELECT hora FROM citas WHERE id_dentista = ? and fecha = ?';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id, $fecha]);
    $row=$stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    return $row;  
    
   }

   function getHoraEntradaYSalida($id) {
    $sql = 'SELECT hora_inicio, hora_fin FROM disponibilidad WHERE id_dentista = ?';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

   public function seleccionaUltimaCita($id){
    $sql ="SELECT MAX(fecha) FROM citas WHERE id_paciente = ? ";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id]);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
   }
}