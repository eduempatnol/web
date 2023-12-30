<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentoringCheckout extends Model
{
    use HasFactory;

    public function schedule() {
        return $this->belongsTo(ScheduleMentoring::class, "schedule_id");
    }

    public function invoices() {
        return $this->hasMany(MentoringInvoice::class, "mentoring_checkout_id");
    }
}
