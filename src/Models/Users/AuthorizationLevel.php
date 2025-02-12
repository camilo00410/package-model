<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

class AuthorizationLevel extends Model
{
    use DefaultLogs;

    const TYPE_MANAGEMENT_ID = 1;
    const TYPE_READ_ID = 2;
    const TYPE_ADMINISTRADOR = 3;

    public $timestamps = false;
}
