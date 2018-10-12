<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cleaner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cleaners';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'quality_score'];

    /**
     * The cities this cleaner operates in
     */
    public function cities()
    {
        return $this->belongsToMany('App\City');
    }

    /**
     * All bookings of this cleaner
     */
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }    
    
}
