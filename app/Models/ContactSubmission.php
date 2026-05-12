<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company',
        'service', 'message', 'status', 'ip_address',
    ];
}
