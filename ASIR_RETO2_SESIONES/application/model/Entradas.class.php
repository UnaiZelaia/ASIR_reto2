<?php
class entradas {

private $idEntr_Sal;
private $idUsuario;
private $Fecha;
private $Hora;
private $Entr_Sali;



/**
 * Get the value of idEntr_Sal
 */ 
public function getIdEntr_Sal()
{
        return $this->idEntr_Sal;
}

/**
 * Set the value of idEntr_Sal
 *
 * @return  self
 */ 
public function setIdEntr_Sal($idEntr_Sal)
{
        $this->idEntr_Sal = $idEntr_Sal;

        return $this;
}

/**
 * Get the value of idUsuario
 */ 
public function getIdUsuario()
{
        return $this->idUsuario;
}

/**
 * Set the value of idUsuario
 *
 * @return  self
 */ 
public function setIdUsuario($idUsuario)
{
        $this->idUsuario = $idUsuario;

        return $this;
}

/**
 * Get the value of Fecha
 */ 
public function getFecha()
{
        return $this->Fecha;
}

/**
 * Set the value of Fecha
 *
 * @return  self
 */ 
public function setFecha($Fecha)
{
        $this->Fecha = $Fecha;

        return $this;
}

/**
 * Get the value of Hora
 */ 
public function getHora()
{
        return $this->Hora;
}

/**
 * Set the value of Hora
 *
 * @return  self
 */ 
public function setHora($Hora)
{
        $this->Hora = $Hora;

        return $this;
}

/**
 * Get the value of Entr_Sali
 */ 
public function getEntr_Sali()
{
        return $this->Entr_Sali;
}

/**
 * Set the value of Entr_Sali
 *
 * @return  self
 */ 
public function setEntr_Sali($Entr_Sali)
{
        $this->Entr_Sali = $Entr_Sali;

        return $this;
}
}
?>