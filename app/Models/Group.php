<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'name',
        'description',
        'token'
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, GroupsUsers::class, 'group_id', 'id', 'id', 'user_id');
    }
}
