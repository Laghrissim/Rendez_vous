<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
class Client extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    public function Appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
        
    }
}
