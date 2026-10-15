<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table = 'register';
    protected $primaryKey = 'register_id';
    public $timestamps = false;

    protected $fillable = ['register_date', 'student_id', 'semester'];

    public function details()
    {
        return $this->hasMany(RegisterDetail::class, 'register_id', 'register_id');
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'student_id');
    }
}
