<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Category extends Model
  {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';
    /**
     * The primary key associated with model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
  }