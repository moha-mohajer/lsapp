<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table Name
    protected $table = 'posts';
    // Primery Key
    public $primeryKey = 'id';
    // Timestams
    public $timestamps= true;
}
