<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    public function benefits() {
        return $this->hasMany(VoucherBenefit::class, "voucher_id");
    }
}
