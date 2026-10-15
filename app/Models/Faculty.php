<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table      = 'faculty';
    protected $primaryKey = 'faculty_id';


    protected $fillable = [
        'faculty_id',
        'faculty_name',
        'created_at',
        'updated_at'
    ];
    //
    public function teachers()
    {
        return $this->hasMany(
            Teacher::class,
            'faculty_id',   // FK ใน students
            'faculty_id'    // PK ใน faculty
        );
    }
    public function programs()
    {
        return $this->hasMany(
            Program::class,
            'faculty_id',   // FK ใน program
            'faculty_id'    // PK ใน faculty
        );
    }

    // Faculty มีหลาย Student (ผ่าน program หรือตรงๆ)
    public function students()
    {
        return $this->hasMany(
            Students::class,
            'faculty_id',   // FK ใน students
            'faculty_id'    // PK ใน faculty
        );
    }

    public function programsCount()
    {
        return $this->programs()->count();
    }
}
