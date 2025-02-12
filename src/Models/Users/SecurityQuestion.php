<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

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
