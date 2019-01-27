<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Author extends Model
  {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'authors';
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
  }