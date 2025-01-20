<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{

    public $timestamps = false;
    
    const UPDATED_AT = 'updated_at';


    protected $fillable = [
        'bulletin_title',
        'pdf_file_path',
        'description',
        // 'is_active',
        'published_at'
    ];



    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }


    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
