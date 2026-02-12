<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "refunds";

    protected $guarded = [];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
