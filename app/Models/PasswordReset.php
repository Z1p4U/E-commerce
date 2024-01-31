<?php

namespace App\Models;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model implements ShouldQueue
{
    use HasFactory;

    protected $fillable = ['email', 'token', 'created_at'];

    public $timestamps = false;
}
