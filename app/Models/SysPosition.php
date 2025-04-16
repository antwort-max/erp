<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysPosition extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    // Relación con usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
