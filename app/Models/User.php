<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SysPosition;
use App\Models\SysDepartment;
use App\Models\SysRole;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name','email','password',
        'dni','code',
        'phone','whatsapp','date_of_birth','gender','address','avatar_path',
        'position_id','department_id','role_id',
        'supplier_company_name','supplier_company_email','supplier_company_info',
        'metadata',
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth'     => 'date',
        'metadata'          => 'array',
    ];

    public function position(): BelongsTo
    {
        return $this
            ->belongsTo(SysPosition::class, 'position_id')
            ->withDefault(['name' => 'Sin posición']);
    }

    public function department(): BelongsTo
    {
        return $this
            ->belongsTo(SysDepartment::class, 'department_id')
            ->withDefault(['name' => 'Sin departamento']);
    }

    /** 
     * Evitamos el nombre `role()` para no chocar con Spatie. 
     */
    public function Role(): BelongsTo
    {
        return $this
            ->belongsTo(Role::class, 'role_id')
            ->withDefault(['name' => 'Sin rol']);
    }
}
