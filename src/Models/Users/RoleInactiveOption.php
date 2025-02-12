<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

class RoleInactiveOption extends Model
{
    use DefaultLogs;

    protected $fillable = [
        'option'
    ];
}
