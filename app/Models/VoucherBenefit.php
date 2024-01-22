<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherBenefit extends Model
{
    use HasFactory;

    public function voucher() {
        return $this->belongsTo(Voucher::class, "voucher_id");
    }
}
