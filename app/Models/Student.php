<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// class Student extends Model
class Student extends Authenticatable
{
    use HasFactory;

    protected $table = 'tbl_personal_details';

    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function images()
    {
        return $this->hasMany(StudentImage::class, 'student_id');
    }
}