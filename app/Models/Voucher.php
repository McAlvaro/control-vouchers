<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected  $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($voucher) {
            $voucher->voucher_number = static::generateNextVoucherNumber();
        });

        static::deleting(function ($voucher) {
            $voucher->items()->delete();
        });
    }

    private  static function generateNextVoucherNumber()
    {
        $lastVoucher = DB::table('vouchers')->orderBy('id', 'desc')->first();

        $nextNumber = $lastVoucher ? (int) $lastVoucher->voucher_number + 1 : 1;

        return str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function items()
    {
        return $this->hasMany(VoucherItem::class);
    }
}
