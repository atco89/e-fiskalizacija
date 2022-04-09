<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

enum CashierDisplayType: string
{
    case IDENTIFIER = 'IDENTIFIER';
    case NAME = 'NAME';
    case SURNAME = 'SURNAME';
    case NAME_SURNAME = 'NAME_SURNAME';
    case FULL_NAME = 'FULL_NAME';
}
