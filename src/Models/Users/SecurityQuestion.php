<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    use DefaultLogs;
    use HasFactory;

    protected $fillable = ['question'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
