<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasPermissions;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'address',
        'user_id',
    ];

    protected $table = 'addresses';
}
