<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table      = 'program';
    protected $primaryKey = 'program_id';
    public $incrementing  = false;
    protected $keyType     = 'string';


    protected $fillable = [
        'program_id',
        'program_name',
        'faculty_id',
        'created_at',
        'updated_at'

    ];

    // Program อยู่ใน Faculty
    public function faculty()
    {
        return $this->belongsTo(
            Faculty::class,
            'faculty_id',   // FK ใน program
            'faculty_id'    // PK ใน faculty
        );
    }

    public function students()
    {
        return $this->hasMany(
            Students::class,
            'program_id',   // FK ใน students
            'program_id'    // PK ใน program
        );
    }
    public function teachers()
    {
        return $this->hasMany(
            Teacher::class,
            'program_id',   // FK ใน students
            'program_id'    // PK ใน program
        );
    }
}