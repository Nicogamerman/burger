<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model{

      protected $table = 'pedidos';
      public $timestamps = false;
  
      protected $fillable = [
          'idpedido',
          'fecha',
          'descripcion',
          'total',
          'fk_idsucursal',
          'fk_idcliente',
          'fk_idestado'          
      ];
  
      protected $hidden = [
  
      ];
  
    public function insertar(){
        $sql = "INSERT INTO $this->table (                       
            fecha,
            descripcion,
            total,  
            fk_idsucursal,
            fk_idcliente,
            fk_idestado            
            ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [            
            $this->fecha,
            $this->descripcion,
            $this->total, 
            $this->fk_idsucursal,
            $this->fk_idcliente,
            $this->fk_idestado             
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    public function obtenerPorId($idpedido)
    {
        $sql = "SELECT
                idpedido,
                fecha,
                descripcion,
                total,
                fk_idsucursal,                
                fk_idcliente,
                fk_idestado                
                FROM pedidos WHERE idpedido = $idpedido";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {            
            $this->fecha = $lstRetorno[0]->fecha;            
            $this->total = $lstRetorno[0]->total;
            $this->descripcion = $lstRetorno[0]->descripcion;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;      
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;     
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;          
            return $this;
        }
        return null;
    }

    public function guardar() {
        $sql = "UPDATE $this->table SET
            fecha='$this->fecha',            
            descripcion=$this->descripcion,
            total=$this->total,            
            fk_idcategoria=$this->fk_idcategoria,
            fk_idcliente=$this->fk_idcliente,
            fk_idestado=$this->fk_idestado
            WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function eliminar(){
        $sql = "DELETE FROM $this->table WHERE idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                  A.idpedido,
                  A.fk_idcliente                                   
                FROM pedidos A ORDER BY A.idpedido";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}