<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoints extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'user_id',
        'points'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
