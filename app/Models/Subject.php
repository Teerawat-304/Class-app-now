<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table      = 'subject';
    protected $primaryKey = 'subject_code';
    public $incrementing  = false;
    protected $keyType     = 'string';

    // ตาราง subject ไม่มีคอลัมน์ created_at / updated_at
    public $timestamps = false;

    protected $fillable = [
        'subject_name',
        'subject_code',
        'credit',
    ];

    /**
     * คืนค่า id หรือ subject_code หากตารางไม่มีคอลัมน์ id
     */
    public function getIdAttribute($value)
    {
        return $value ?? $this->attributes['subject_code'] ?? null;
    }

    // รายวิชานี้ถูกลงทะเบียนเรียนไว้ในรายละเอียดการลงทะเบียนใด (ผ่าน subject_code)
    public function registerDetails()
    {
        return $this->hasMany(
            RegisterDetail::class,
            'subject_code',   // FK ใน register_detail
            'subject_code'    // คีย์ใน subject
        );
    }

    // การมอบหมายอาจารย์ผู้สอนประจำรายวิชานี้
    public function subjectTeachers()
    {
        return $this->hasMany(
            SubjectTeacher::class,
            'subject_code',
            'subject_code'
        );
    }

    // รายชื่ออาจารย์ที่สอนวิชานี้
    public function teachers()
    {
        return $this->belongsToMany(
            Teacher::class,
            'subject_teacher',
            'subject_code',
            'teacher_id',
            'subject_code',
            'teacher_id'
        );
    }
}
