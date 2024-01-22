<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model implements ShouldQueue
{
    use HasFactory, Queueable;

    protected $fillable = ['email', 'token', 'created_at'];

    public $timestamps = false;
}
