<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
protected $fillable = [
        'user_id',      // <-- ye add karo
        'dark_mode',    // already existing field
        // agar aur fields hain unko bhi yahan add karo
    ];
}
