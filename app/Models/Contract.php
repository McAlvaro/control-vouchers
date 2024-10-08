<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = "contracts";

    protected $guarded = [];

    public function vouchers() {
        return $this->hasMany(Voucher::class);
    }
}
