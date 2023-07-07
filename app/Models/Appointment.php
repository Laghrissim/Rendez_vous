<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'date',
    ];
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function Docteur(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
