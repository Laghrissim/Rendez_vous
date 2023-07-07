<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docteur extends Model
{
    use HasFactory;
    public function Appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
