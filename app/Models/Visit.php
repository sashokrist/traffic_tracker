<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address', 'page_url', 'visited_at'];
    public $timestamps = true; // or false if you don't want created_at/updated_atphp artisan migrate:status

}
