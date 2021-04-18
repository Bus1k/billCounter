<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Bill::class);
    }
}
