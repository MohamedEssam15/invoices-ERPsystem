<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];
    public function user()
    {
        return $this->belongsTo('app\Models\User', 'user_id' );
    }

}
