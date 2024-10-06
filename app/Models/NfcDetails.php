<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NfcDetails extends Model
{
    use HasFactory;

    protected $table = 'nfc_details';

    protected $fillable = [
        'card_id',
        'business_name',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];
}
