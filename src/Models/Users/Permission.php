<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Models\Permission as PermissionRole;
use Spatie\Permission\Traits\RefreshesPermissionCache;

class Permission extends PermissionRole implements PermissionContract
{
    use DefaultLogs;
    use HasFactory;
    use RefreshesPermissionCache;

    protected $guard_name = 'sanctum';

    protected function getDefaultGuardName(): string
    {
        return env('AUTH_GUARD');
    }

    const ALLOW = 'Permitido';

    const NOT_ALLOW = 'No Permitido';

    public function moduleApp()
    {
        return $this->belongsTo(ModuleApp::class);
    }
}
