<?php

namespace App\Constants;

class TransactionStatusConstants
{
    public const PENDING = 'pending';
    public const SUCCESS = 'success';
    public const FAILED = 'failed';

    public const LIST = [
        self::PENDING,
        self::SUCCESS,
        self::FAILED
    ];
}
