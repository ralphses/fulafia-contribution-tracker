<?php

namespace App\Utils;

class Utils
{
    const ROLE_ADMIN = "admin";
    const ROLE_STAFF = "staff";
    const ROLE_STUDENT = "student";

    const TYPE_WEEKLY = "weekly";
    const TYPE_MONTHLY = "monthly";
    const TYPE_YEARLY = "yearly";
    const TYPE_DAYLY = "daily";
    const TYPE_QUARTERLY = "quarterly";

    public const STATUS_ACTIVE = "active";
    public const STATUS_INACTIVE = "in-active";
    public const STATUS_REJECTED = "rejected";

    public const ROLES = [self::ROLE_ADMIN, self::ROLE_STAFF, self::ROLE_STUDENT];
    const STATUSES = [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_REJECTED];
    const TYPES = [
        self::TYPE_WEEKLY,
        self::TYPE_MONTHLY,
        self::TYPE_YEARLY,
        self::TYPE_DAYLY,
        self::TYPE_QUARTERLY
    ];

    const WITHDRAWAL_STATUS_REQUESTED = "requested";
    const WITHDRAWAL_STATUS_REJECTED = "rejected";
    const WITHDRAWAL_STATUS_CANCELLED = "cancelled";
    const WITHDRAWAL_STATUS_SUCCESSFUL = "successful";

    const WITHDRAWAL_STATUSES = [
        self::WITHDRAWAL_STATUS_REQUESTED,
        self::WITHDRAWAL_STATUS_REJECTED,
        self::WITHDRAWAL_STATUS_CANCELLED,
        self::WITHDRAWAL_STATUS_SUCCESSFUL
    ];

}
