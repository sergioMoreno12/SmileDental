<?php

Class Hora extends Query{

    public function getHorasOcupadas($fecha){
        $generales = ['40', '41', '42', '43'];
        $sql = "SELECT id_dentista, hora FROM citas WHERE fecha = ? AND id_dentista IN (" . implode(',', $generales) . ")";
        $stmt = $this->connect()->prepare($sql);  
        $stmt->execute([$fecha]);
        $row = $stmt->fetchAll();
        return $row;
    }
    
    public function getTodasHoras(){
        $sergio = ["id_dentista" => 40, "horaI"=>8, "horaF"=>16];
        $jessica = ["id_dentista" => 41, "horaI"=>8, "horaF"=>16];
        $giovanni = ["id_dentista" => 42, "horaI"=>13, "horaF"=>21];
        $emmanuel = ["id_dentista" => 43, "horaI"=>13, "horaF"=>21];

        $dentistas = [$sergio, $jessica, $giovanni, $emmanuel];
        $horas=[];
        for($i=0; $i < count($dentistas); $i++){
            for($j = $dentistas[$i]['horaI']; $j < $dentistas[$i]["horaF"]; $j++){
                array_push($horas, ["id_dentista" => $dentistas[$i]["id_dentista"], "hora"=>$j]);
            }
        }

        return $horas;
    }

    public function getHorasLibres($fecha){
        $ocupadas = $this->getHorasOcupadas($fecha);
        $todas = $this->getTodasHoras();
        $ocupadasSerialized = array_map('serialize', $ocupadas);
        $todasSerialized = array_map('serialize', $todas);
        $disponibleSerialized = array_diff($todasSerialized, $ocupadasSerialized);
        $disponible = array_map('unserialize', $disponibleSerialized);
        return $disponible;
    }
    
    
    public function getHoraLibrePorNumero($fecha){
        $disponible = $this->getHorasLibres($fecha);
        $horas = array_column($disponible, 'hora');
        sort($horas);

        $horas = array_unique($horas);
        
        return $horas;
    }
    
    public function getIdGeneral($hora){
        $sql = 'SELECT id_odontologo FROM general WHERE ? BETWEEN hora_inicio AND hora_fin';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$hora]);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN); // Obtiene todos los valores de la columna como un array
        return array_map('intval', $rows); // Convierte todos los valores a enteros y retorna el array
    }
    
    public function revisaCitas($fecha, $hora){
        $sql = 'SELECT id_dentista FROM citas WHERE fecha = ? AND hora = ?';
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$fecha, $hora]);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN); // Obtiene todos los valores de la columna como un array
        return array_map('intval', $rows); // Convierte todos los valores a enteros y retorna el array
    }
    
}    