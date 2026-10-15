<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    protected $table = 'subject_teacher';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'subject_code',
        'teacher_id',
    ];

    /** ความสัมพันธ์กับรายวิชา */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_code', 'subject_code');
    }

    /** ความสัมพันธ์กับผู้สอน */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }
}