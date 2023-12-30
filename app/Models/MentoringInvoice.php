<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentoringInvoice extends Model
{
    use HasFactory;

    public function checkout() {
        return $this->belongsTo(MentoringCheckout::class, "mentoring_checkout_id");
    }
}
