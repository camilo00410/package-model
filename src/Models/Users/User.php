<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use App\Models\Traits\HasRolesCustom;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use CausesActivity;
    use DefaultLogs;
    use HasApiTokens, HasFactory, HasRolesCustom, Notifiable;

    const NOT_LOGGED_IN = 1;

    const LOGGED_IN = 0;

    protected $guard_name = 'sanctum';

    protected function getDefaultGuardName(): string
    {
        return env('AUTH_GUARD');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'document',
        'phone',
        'email',
        'first_login',
        'has_security_question',
        'security_question_id',
        'security_answer',
        'security_question_reminder',
        'document_type_id',
        'sex',
        'photo',
        'expedition_place_id',
        'expiration_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'validation_phone',
        'is_validation_phone_active',
        'validation_email',
        'is_validation_email_active',
        'bank_id',
        'branch_id',
        'status_id',
        'account_number',
        'account_type',
        'password',
        'is_expired_to_role',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withRelations', function (Builder $builder) {
            $builder->with(['status', 'documentType', 'documents', 'roles:id,name']);
        });
    }

    public function allowedWarehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'allowed_user_warehouse');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'expiration_date' => 'date',
            'status_id' => 'integer',
            'is_expired_to_role' => 'boolean',
        ];
    }

    /**
     * Many-to-many relationship with AuthenticationMethod.
     * Includes 'status_id' and 'last_used_at' from the pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authenticationMethods()
    {
        return $this->belongsToMany(AuthenticationMethod::class, 'authentication_method_user')
            ->withPivot('id', 'status_id', 'last_used_at', 'secret_2fa', 'is_verified', 'failed_attempts', 'created_at');
    }

    public function getAuthenticationMethodsWithFormattedCreatedAt()
    {
        return $this->authenticationMethods()->get()->map(function ($method) {
            $method->pivot->created_at = \Carbon\Carbon::parse($method->pivot->created_at)->format('d-m-Y H:i:s');

            return $method;
        });
    }

    public function authenticationMethodsActives()
    {
        return $this->belongsToMany(AuthenticationMethod::class, 'authentication_method_user')
            ->withPivot('status_id', 'last_used_at', 'secret_2fa', 'is_verified', 'created_at')
            ->wherePivot('status_id', Status::STATUS_ACTIVE);
    }

    public function authenticationMethodsIsVerified()
    {
        return $this->belongsToMany(AuthenticationMethod::class, 'authentication_method_user')
            ->withPivot('status_id', 'last_used_at', 'secret_2fa', 'is_verified', 'created_at')
            ->wherePivot('is_verified', 1);
    }

    /**
     * One-to-many relationship with AuthenticationLog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authenticationLogs()
    {
        return $this->hasMany(AuthenticationLog::class);
    }

    /**
     * Get the status that the user belongs to.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * Get the status that the user belongs to.
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    /**
     * Get the branch that the user belongs to.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get the document type that the user belongs to.
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id')->where('model', 'user');
    }

    /**
     * Get the Security Question that the user belongs to.
     */
    public function securityQuestion(): BelongsTo
    {
        return $this->belongsTo(SecurityQuestion::class, 'security_question_id');
    }

    /**
     * Get the URL of the signature if it exists, otherwise return null.
     */
    protected function signature(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ! empty($value) ? Storage::url($value) : null,
        );
    }

    /**
     * Get the URL of the photo if it exists, otherwise return null.
     */
    protected function photo(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ! empty($value) ? Storage::url($value) : null,
        );
    }

    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->name.' '.$this->last_name
        );
    }

    /**
     * Get the expedition place that the user belongs to.
     */
    public function expeditionPlace(): BelongsTo
    {
        return $this->belongsTo(City::class, 'expedition_place_id');
    }

    public function documents()
    {
        return $this->morphMany(Documentable::class, 'documentable');
    }

    public function scopeStatusActive($query)
    {
        return $query->where('status_id', Status::STATUS_ACTIVE);
    }

    /**
     * Get menu structure organized by modules with their associated permissions
     *
     * @return array<int, array{
     *    key: string,           The module identifier
     *    name: string,          The module description/name
     *    icon: string,          The module icon identifier
     *    children: array<int, array{
     *        permission: string,    The permission name
     *        name: string,         The permission description
     *        identifier: string,   The permission identifier
     *        path: string         The permission route path
     *    }>
     * }>|array{}
     **/
    public function getMenu(): array
    {
        $permissions = $this->getDirectPermissions()->load('moduleApp');
        $modules = $permissions->groupBy('module_app_id');

        return $modules->map(function ($permissions, $moduleId) {
            $module = $permissions->first()->moduleApp;
            if (! $module) {
                return null;
            }

            return [
                'key' => $module->identifier,
                'name' => $module->description,
                'icon' => $module->icon,
                'children' => $permissions->map(function ($permission) {
                    return [
                        'permission' => $permission->name,
                        'name' => $permission->description,
                        'identifier' => $permission->identifier,
                        'path' => $permission->route,
                    ];
                })->values()->toArray(),
            ];
        })->values()->toArray();
    }

    public function permissionsWithAccess(): array
    {
        $permissionRoles = $this->permissions;

        return $this->roles[0]->permissions->map(function (Permission $permission) use ($permissionRoles) {
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

    public function generateToken(): array
    {
        $token = $this->createToken('MyApp')->plainTextToken;
        $userFiltered = $this->only([
            'id', 'name', 'last_name', 'photo', 'document', 'phone', 'email', 'first_login', 'status_id', 'created_at', 'updated_at',
        ]);

        $role = $this->roles->pluck('name')->first();
        $permissions = $this->getPermissionsViaRoles()->pluck('name');

        return [
            'user' => $userFiltered,
            'role' => $role,
            'permissions' => $permissions,
            'authorization' => [
                'token' => $token,
                'type' => 'Bearer',
            ],
            'menu' => $this->getMenu(),
        ];
    }

    public function isActive(): bool
    {
        return $this->status_id == Status::STATUS_ACTIVE;
    }

    public function activitiesLogs()
    {
        return $this->hasMany(Activity::class, 'causer_id', 'id');
    }
}
