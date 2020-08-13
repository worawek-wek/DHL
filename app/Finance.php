<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        "deduct_tax_identification",
        "deduct_name",
        "address_number",
        "address_moo",
        "address_alley",
        "address_street",
        "address_subdistrict",
        "address_district",
        "address_province",
        "address_zipcode",
        "phone",
        "month_pay",
        "year_pay",
        "attachment",
        "media",
        "qty_case",
        "qty_sheet",
        "total_amount",
        "total_tax",
        "extra_money",
        "total_tax_delivered"

    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'finances';
}
