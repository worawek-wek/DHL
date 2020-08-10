<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        "companyTaxNo",
        "companyBranch",
        "companyName",
        "companyEnglishName",
        "streetAndNumber",
        "district",
        "subProvince",
        "province",
        "postCode"
    ];

    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'customers';
}
