<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'user_id', 
        'document_unique_id', 
        'document_category', 
        'document_url', 
        'document_format', 
        'description' ,
        'assigned_id', 
    ];
}
