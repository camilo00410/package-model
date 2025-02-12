<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Illuminate\Database\Eloquent\Model;

class RoleInactiveOption extends Model
{
    use DefaultLogs;

    protected $fillable = [
        'option',
    ];
}
