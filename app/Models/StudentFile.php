<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFile extends Model
{
    use HasFactory;

    protected $table = 'tbl_student_files';

    protected $fillable = [
        'student_id',
        'file_name',
        'file_path',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}