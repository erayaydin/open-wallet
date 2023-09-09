<?php

namespace OpenWallet\Models;

enum AccountType: string
{
    case Cash = 'cash';
    case Deposit = 'deposit';
    case CreditCard = 'credit_card';
}
