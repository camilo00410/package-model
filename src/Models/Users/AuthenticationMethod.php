<?php

namespace Fidu\Models\Models\Users;

use App\Models\Traits\DefaultLogs;
use Illuminate\Database\Eloquent\Model;

class AuthenticationMethod extends Model
{
    use DefaultLogs;

    const SMS_EMAIL = 'sms_email';

    const GOOGLE_AUTHENTICATOR = 'google_auth';

    const MICROSOFT_AUTHENTICATOR = 'microsoft_auth';

    protected $fillable = ['method', 'abbreviation'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Many-to-many relationship with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'authentication_method_user')
            ->withPivot('registered_at', 'last_used_at', 'secret_2fa', 'created_at', 'is_verified');
    }

    /**
     * One-to-many relationship with AuthenticationLog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(AuthenticationLog::class);
    }
}
