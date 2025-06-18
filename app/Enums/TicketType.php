<?php

namespace App\Enums;

enum TicketType: string
{
    case BILLING = 'billing';
    case TECHNICAL_SUPPORT = 'technical_support';
    case ACCOUNT_MANAGEMENT = 'account_management';
    case FEATURE_REQUEST = 'feature_request';
}
