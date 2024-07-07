<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'value',
        'link',
        'type',
        'created_at',
        'updated_at',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
