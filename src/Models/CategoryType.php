<?php

namespace OpenWallet\Models;

enum CategoryType: string
{
    case Must = 'must';
    case Need = 'need';
    case Want = 'want';
}
