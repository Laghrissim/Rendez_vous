<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'date','status', 'user_id','doctor_id'];
    protected $casts = [
        'options' => 'array',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Docteur::class);
    }
    // public function doctor()
    // {
    //     return $this->belongsTo(User::class, 'doctor_id');
    // }
   
}
