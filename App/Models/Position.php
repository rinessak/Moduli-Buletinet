<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model ;

class Position extends Model
{
    // public $timestamps = false;

    protected $fillable = [
        'faculty_id',     
        'position',          
        'description',
    ];


    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }
}