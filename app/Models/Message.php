<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Define the relationship with the receiver of this message
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function senderDoctor()
    {
        return $this->belongsTo(Docteur::class, 'sender_id');
    }

    // Define the relationship with the receiver of this message
    public function receiverDoctor()
    {
        return $this->belongsTo(Docteur::class, 'receiver_id');
    }
}
