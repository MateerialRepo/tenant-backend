<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReferee extends Model
{
    use HasFactory;

    protected $table = 'user_referees';

    protected $primaryKey = 'id';

    protected $fillable = [ 'user_id', 'first_name', 'last_name', 'email', 'phone_number', 'address' ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
