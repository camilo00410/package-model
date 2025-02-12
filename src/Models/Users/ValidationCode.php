<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\CausesActivity;

class ValidationCode extends Model
{
    use CausesActivity;
    use DefaultLogs;
    use HasFactory;

    const EMAIL_TYPE = 'email';

    const SMS_TYPE = 'sms';

    protected $fillable = [
        'user_id',
        'type',
        'contact',
        'code',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
