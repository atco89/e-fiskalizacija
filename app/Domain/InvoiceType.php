<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

enum InvoiceType: int
{
    case NORMAL = 0;
    case PROFORMA = 1;
    case COPY = 2;
    case TRAINING = 3;
    case ADVANCE = 4;
}
