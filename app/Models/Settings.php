<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'user_id',
        'name',
        'value'
    ];
}
