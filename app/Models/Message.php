<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id', 'receiver_id', 'message',
    ];

    // Get the sender (Owner or Customer)
    public function sender()
    {
        return $this->belongsTo(Owner::class, 'sender_id');
    }

    // Get the receiver (Owner or Customer)
    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }

}
