<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

class City extends Model
{
    use DefaultLogs;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'department_id',
        'code',
        'name'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status_id' => 'integer',
    ];
}
