<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cotacao_frete extends Model
{
    use HasFactory;

    protected $fillable = [
        'uf',
        'porcentual_cotacao',
        'valor_extra',
        'transportadora_id'
    ];

    public function transportadora()
    {
        return $this->belongsTo(transportadora::class);
    }
}
