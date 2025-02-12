<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Illuminate\Database\Eloquent\Model;

class AuthorizationLevel extends Model
{
    use DefaultLogs;

    const TYPE_MANAGEMENT_ID = 1;

    const TYPE_READ_ID = 2;

    const TYPE_ADMINISTRADOR = 3;

    public $timestamps = false;
}
