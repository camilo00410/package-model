<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use DefaultLogs;
    use HasFactory;

    protected $guard_name = 'sanctum';

    protected function getDefaultGuardName(): string
    {
        return env('AUTH_GUARD');
    }

    protected $casts = [
        'authorization_level_id' => 'integer',
        'is_schedule_restricted' => 'boolean',
        'has_password_policy' => 'boolean',
        'has_expiration' => 'boolean',
        'requires_mfa' => 'boolean',
        'status_id' => 'integer',
    ];

    public function getScheduleStartHourAttribute($value): Carbon
    {
        return Carbon::createFromTimeString(date('H:i', strtotime($value)));
    }

    public function getScheduleEndHourAttribute($value): Carbon
    {
        return Carbon::createFromTimeString(date('H:i', strtotime($value)));
    }

    public function setScheduleEndHourAttribute($value): void
    {
        $this->attributes['schedule_end_hour'] = Carbon::createFromTimeString(date('H:i', strtotime($value)));
    }

    public function setScheduleStartHourAttribute($value): void
    {
        $this->attributes['schedule_start_hour'] = Carbon::createFromTimeString(date('H:i', strtotime($value)));
    }

    /*
     * this method give relationship to status table
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function authorizationLevel(): BelongsTo
    {
        return $this->belongsTo(AuthorizationLevel::class);
    }

    public function users(): BelongsToMany
    {
        return $this->morphedByMany(
            User::class,
            'model',
            config('permission.table_names.model_has_roles'))->withTimestamps();
    }

    public function permissionsWithAccess(): array
    {
        $permissionRoles = $this->permissions;

        return Permission::all()->map(function (Permission $permission) use ($permissionRoles) {
            $item = [
                'id' => $permission->id,
                'name' => $permission->name,
                'module' => $permission->moduleApp->description,
                'description' => $permission->description,
                'status' => Permission::NOT_ALLOW,
                'status_id' => Status::STATUS_INACTIVE,
            ];

            if ($permissionRoles->contains('id', $permission->id)) {
                $item['status'] = Permission::ALLOW;
                $item['status_id'] = Status::STATUS_ACTIVE;

            }

            return $item;
        })->toArray();
    }

    public function getStatusNameAttribute()
    {
        return $this->status();
    }

    public function validateRoleActiveUserZero(): bool
    {
        return $this->users()->count() === 0 && $this->status_id === Status::STATUS_ACTIVE;
    }
}
