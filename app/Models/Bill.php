<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id',
        'description',
        'type',
        'amount',
        'photo_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
