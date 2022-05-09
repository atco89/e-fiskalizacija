<?php
declare(strict_types=1);

namespace TaxCore\Entities\Enums;

enum TaxRateLabel: string
{

    /**
     * Износ плаћеног аванса за промет  ослобођен  ПДВ - 0%
     */
    case TL10 = 'Ж';

    /**
     * Бруто износ плаћеног аванса по ПДВ стопи од 10% - по посебној  стопи
     */
    case TL11 = 'A';

    /**
     * Бруто износ плаћеног аванса по ПДВ стопи од 20% - по општој стопи
     */
    case TL12 = 'B';
}
