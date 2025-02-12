<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

class DocumentType extends Model
{
    use DefaultLogs;
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
