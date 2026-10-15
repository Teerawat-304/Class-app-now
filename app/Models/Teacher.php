<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Teacher extends Authenticatable 
{
    use HasFactory, Notifiable;

    protected $table = 'teacher';
    protected $primaryKey = 'teacher_id';

    // teacher_id เป็น int auto-increment ตามโครงสร้างตาราง จึงไม่ต้องปิด incrementing

    protected $fillable = [
        'teacher_name',
        't_program_id',
        't_faculty_id',
        't_email',
        't_address',
        't_username',
        't_password',
        't_role',
    ];

    protected $hidden = [
        't_password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            't_password' => 'hashed',
            't_role'     => 'integer',
        ];
    }

    /**
     * บอก Laravel ว่ารหัสผ่านจริง ๆ เก็บอยู่คอลัมน์ไหน
     * เพราะตารางนี้ใช้ t_password แทน password มาตรฐาน
     */
    public function getAuthPassword()
    {
        return $this->t_password;
    }

    /** ใช้ t_username เป็น field สำหรับ login แทน email มาตรฐาน */
    public function username()
    {
        return 't_username';
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 't_faculty_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 't_program_id');
    }

    /**
     * เช็คว่าอาจารย์คนนี้มีสิทธิ์แอดมินหรือไม่
     * t_role: 0 = admin, 1 = อาจารย์ธรรมดา (ค่า default ของตาราง)
     */
    public function isAdmin(): bool
    {
        return (int) $this->t_role === 0;
    }
    
}

