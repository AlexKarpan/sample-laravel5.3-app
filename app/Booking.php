<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bookings';

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
    protected $fillable = ['starts_at', 'ends_at', 'customer_id', 'cleaner_id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
    
    /**
     * Cleaner for this booking
     */
    public function cleaner()
    {
        return $this->belongsTo('App\Cleaner');
    }

    /**
     * City of this booking
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    
}
