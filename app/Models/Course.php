<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function lessons() {
        return $this->hasMany(Lessons::class, "course_id");
    }
    
    public function invoices() {
        return $this->hasMany(CourseInvoice::class, "course_id");
    }
}
