<?php
declare(strict_types=1);

namespace Fiskalizacija\Enums;

enum CashierDisplayType: string
{
    case IDENTIFIER = 'IDENTIFIER';
    case NAME = 'NAME';
    case SURNAME = 'SURNAME';
    case FULL_NAME = 'FULL_NAME';
}
