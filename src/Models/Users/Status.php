<?php

namespace Fidu\Models\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\DefaultLogs;

class Status extends Model
{
    use DefaultLogs;
    use HasFactory;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;
    public const STATUS_NEW = 3;
    public const STATUS_INGRESS_PROCESS = 4;
    public const STATUS_RETURNED = 5;
    public const STATUS_SENT = 6;
    public const STATUS_END = 7;
    public const STATUS_PENDING_APPROVAL = 8;
    public const STATUS_APPROVED = 9;
    public const STATUS_REJECTED = 10;
    public const STATUS_ANNULLED = 11;
    public const STATUS_PENDING_REGISTER = 12;
    public const STATUS_DELIVERED = 13;
    public const STATUS_NOT_DELIVERED = 14;
    public const STATUS_RECEIVED = 15;
    public const STATUS_NOT_RECEIVED = 16;
    public const STATUS_GOOD = 17;
    public const STATUS_REGULAR = 18;
    public const STATUS_BAD = 19;
    public const STATUS_DISCHARGED = 20;
    public const STATUS_TRANSFER = 21;
    public const STATUS_REUSABLE = 22;
    public const STATUS_REVERSED = 23;
    public const STATUS_PROCESSED = 24;
    public const STATUS_PENDING = 25;
    public const STATUS_IN_PROCESS = 26;
    public const STATUS_PENDING_REJECTION = 27;
    public const STATUS_REJECTED_ANNULLED = 28;
    public const STATUS_COMPLETED = 29;
    public const STATUS_ERRORS = 30;
    public const STATUS_REVIEWED = 31;
    public const STATUS_CLOSED = 32;
    public const STATUS_SERVICE = 33;
    public const STATUS_PROGRAMMED = 34;
    public const STATUS_TO_VERIFY = 35;
    public const STATUS_UNREALIZED = 36;
    public const STATUS_REALIZED = 37;
    public const STATUS_PENDING_DEPRECIATION = 38;
    public const STATUS_CANCELED = 39;
    public const STATUS_EXCELLENT = 40;
    public const STATUS_GOOD_CONDITION = 41;
    public const STATUS_NORMAL_WEAR = 42;
    public const STATUS_OBSOLETE = 43;
    public const STATUS_DAMAGED = 44;
    public const STATUS_REPAIRED = 45;
    public const STATUS_DETERIORATING = 46;
    public const STATUS_WAITING_REPAIR = 47;
    public const STATUS_IRREPARABLE = 48;
    public const STATUS_OUT_OF_SERVICE = 49;
    public const STATUS_DISPOSED = 50;

    protected $fillable = [
        'status',
        'id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
