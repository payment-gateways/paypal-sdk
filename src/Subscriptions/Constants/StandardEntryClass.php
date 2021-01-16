<?php

namespace PaymentGateway\PayPalSdk\Subscriptions\Constants;

/**
 * ACH Standard Entry Class (SEC) Codes
 */
interface StandardEntryClass
{
    public const TELEPHONE_INITIATED_ENTRY = 'TEL';
    public const INTERNET_INITIATED_ENTRY = 'WEB';
    public const CASH_CONCENTRATION_AND_DISBURSEMENT = 'CCD';
    public const PREARRANGED_PAYMENT_AND_DEPOSIT = 'PPD';
}
