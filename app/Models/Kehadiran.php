<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'Kehadiran';
    protected $primarykey = 'id';
    public $timestamps = false;
    protected $fillable = ['id_user','date','time','status'];
}
