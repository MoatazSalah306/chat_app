<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable=["user_id","conversation_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
