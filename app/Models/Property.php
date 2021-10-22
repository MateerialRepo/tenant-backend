<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'property_images' => 'array'
    ];

    protected $fillable = [ 
        'user_id', 
        'title', 
        'verified', 
        'property_type', 
        'property_amount', 
        'property_images' ,
        'bedrooms', 
        'bathrooms', 
        'serviced', 
        'parking', 
        'availability', 
        'year_built', 
        'street', 
        'lga', 
        'state', 
        'country', 
        'zipcode', 
        'preferred_religion', 
        'preferred_tribe', 
        'preferred_marital_status', 
        'preferred_employment_status', 
        'preferred_gender', 
        'max_coresidents', 
        'amenities', 
        'side_attraction_categories', 
        'side_attraction_details', 
    ];

    public function setPropertyImagesAttribute($value)
	{
	    $property_images = [];

	    foreach ($value as $array_item) {
	        if (!is_null($array_item['key'])) {
	            $property_images[] = $array_item;
	        }
	    }

	    $this->attributes['property_images'] = json_encode($property_images);
	}

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }

    public function PropertyVerification()
    {
        return $this->hasOne(PropertyVerification::class);
    }


}
