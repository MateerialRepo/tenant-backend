<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNextOfKin extends Model
{
    use HasFactory;

    protected $table = 'user_next_of_kin';

    protected $primaryKey = 'id';

    protected $fillable = [ 'user_id', 'first_name', 'last_name', 'email', 'phone_number', 'relationship' ];

    public function user(){
        return $this->belongsTo(Car::class);
    }
}
