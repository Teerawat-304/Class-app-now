<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterDetail extends Model
{
    protected $table = 'registerr_detail';
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    protected $fillable = [
        'register_id',
        'subject_code',
        'teacher_id',
        'subscore',
        'midterm_score',
        'final_score',
        'total_score',
        'grade',
    ];

    public function register()
    {
        return $this->belongsTo(Register::class, 'register_id', 'register_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_code', 'subject_code');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id'); // ปรับ local key ให้ตรง PK ของ Teacher
    }
}
