<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

class ModuleApp extends Model
{
    use DefaultLogs;
    use HasFactory;

    protected $fillable = [
        'description',
        'identifier',
        'icon',
    ];


}
