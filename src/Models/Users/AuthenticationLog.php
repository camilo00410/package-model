<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Model;

class AuthenticationLog extends Model
{
    protected $fillable = ['user_id', 'authentication_method_id', 'used_at', 'browser_details', 'ip_address'];

    /**
     * Belongs-to relationship with User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs-to relationship with AuthenticationMethod.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function authenticationMethod()
    {
        return $this->belongsTo(AuthenticationMethod::class);
    }
}
