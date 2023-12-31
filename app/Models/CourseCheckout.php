<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCheckout extends Model
{
    use HasFactory;

    public function course() {
        return $this->belongsTo(Course::class, "course_id");
    }

    public function invoice() {
        return $this->belongsTo(CourseInvoice::class, "invoice_id");
    }
}
