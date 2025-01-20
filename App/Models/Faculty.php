<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model ;

class Faculty extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }
}