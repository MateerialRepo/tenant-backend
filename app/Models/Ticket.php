<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $casts = [
        'ticket_img' => 'array',
        // 'assigned_id' => 'array',
    ];

    protected $fillable = [ 
        'user_id', 
        'ticket_unique_id', 
        'ticket_status', 
        'ticket_title', 
        'ticket_category', 
        'description' ,
        'ticket_img', 
        'assigned_id'
    ];


    public function setTicketImgAttribute($value)
    {
        $this->attributes['ticket_img'] = json_encode($value);
    }

    public function getTicketImgAttribute($value)
    {
        return json_decode($value);
    }

    // public function setAssignedIdAttribute($value)
    // {
    //     $this->attributes['assigned_id'] = json_encode($value);
    // }

    // public function getAssignedIdAttribute($value)
    // {
    //     return json_decode($value);
    // }

    public function ticketComment(){
        return $this->hasMany(TicketComment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
