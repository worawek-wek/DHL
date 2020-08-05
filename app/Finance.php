<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        "deduct_tax_identification",
        "deduct_name",
        "deduct_address",
        "represent_tax_identification",
        "represent_name",
        "represent_address",
        "pay_tax_identification",
        "pay_name",
        "pay_address",
        "awb_no",
        "number",
        "date_current",
        "pay_price",
        "pay_tax",
        "pay_tax_text",
        "who_pay",
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'finances';
}
