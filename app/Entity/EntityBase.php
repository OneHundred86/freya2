<?php
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EntityBase{
  protected $model;
  public function __construct(){
  }

  public function setModel(Model $model){
    $this->model = $model;
  }

  public function getModel(){
    return $this->model;
  }

  public function save(){
    return $this->model->save();
  }

  public function __get($property){
    if(isset($this->$property))
      return $this->$property;

    return $this->model->$property;
  }

  public function __set($property, $val){
    $this->model->$property = $val;
  }

  public function __toString(){
    return $this->model->toJson();
  }

  public function __call($func, $args){
    return $this->model->$func(...$args);
  }
}