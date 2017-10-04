<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'description', 'resume', 'birthday'];
}
