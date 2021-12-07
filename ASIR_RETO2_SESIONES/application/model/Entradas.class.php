<?php
class Entradas {

private $idEntr_Sal;
private $idUsuario;
private $Fecha;
private $Hora;
private $Entr;
private $Sali;
private $Hora_Sali;
private $Hora_Entr;



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
 * Get the value of Entr
 */ 
public function getEntr()
{
return $this->Entr;
}

/**
 * Set the value of Entr
 *
 * @return  self
 */ 
public function setEntr($Entr)
{
$this->Entr = $Entr;

return $this;
}

/**
 * Get the value of Sali
 */ 
public function getSali()
{
return $this->Sali;
}

/**
 * Set the value of Sali
 *
 * @return  self
 */ 
public function setSali($Sali)
{
$this->Sali = $Sali;

return $this;
}

/**
 * Get the value of Hora_Sali
 */ 
public function getHora_Sali()
{
return $this->Hora_Sali;
}

/**
 * Set the value of Hora_Sali
 *
 * @return  self
 */ 
public function setHora_Sali($Hora_Sali)
{
$this->Hora_Sali = $Hora_Sali;

return $this;
}

/**
 * Get the value of Hora_Entr
 */ 
public function getHora_Entr()
{
return $this->Hora_Entr;
}

/**
 * Set the value of Hora_Entr
 *
 * @return  self
 */ 
public function setHora_Entr($Hora_Entr)
{
$this->Hora_Entr = $Hora_Entr;

return $this;
}
}