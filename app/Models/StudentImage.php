<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentImage extends Model
{
    use HasFactory;

    protected $table = 'tbl_student_images';

    protected $fillable = [
        'student_id',
        'image_path',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}