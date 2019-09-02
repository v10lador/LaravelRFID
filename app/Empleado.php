<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use League\Flysystem\Config;

class Empleado extends Model
{
    protected $table = "Empleado";
    protected $primaryKey = "idEmpleado";
    protected $fillable = [
        'idEmpleado','idCargo','nombre','segundoNombre','apellidoPaterno','apellidoMaterno'
        ,'estadoCivil','activo','genero','celular','numeroFijo','fechaNacimiento','ci'
        ,'embarazada','fotografia','idReferencia','usuario','contrasena','idRol'
    ];

    public function age(){
        $today = Carbon::today();
        $datework = Carbon::createFromDate($this->fechaNacimiento);
        return   $testdate = $datework->diffInYears($today);
    }
    public function fullName(){
        return $this->apellidoPaterno." ".$this->apellidoMaterno." ".$this->segundoNombre." ".$this->nombre;
    }

    public function cargo()
    {
        return $this->hasOne('App\Cargo','idCargo','idCargo');
    }
    public function asistencias()
    {
        $var = $this->hasMany('App\Asistencia','idEmpleado','idEmpleado');
        return $var;
    }
    public function getAsistencias($fechaInicio='2000-08-01',$fechaFinal=null){
        if ($fechaFinal === null){
            //Cambiando el TIMEZONE DE NUESTRO VARIABLE
            $fechaFinal = Carbon::now()->tz('America/La_Paz')->toDateString();
        }
        $var = $this->asistencias->whereBetween('fecha',[$fechaInicio,$fechaFinal]);
        $fechas = $var->groupBy('fecha');
        return $fechas;
    }
    public function convertirFecha($date){
        $var = Carbon::createFromDate($date);
        return $var ->formatLocalized('%A %d %B %Y');
    }
    public function getHoursOfWork(){
        foreach ($this->getAsistencias() as $fecha)
        {

        }
    }
}
