<?php
declare(strict_types=1);

namespace TaxCore\Entities;

interface Options
{

    /**
     * @return bool
     */
    public function omitQRCodeGen(): bool;

    /**
     * @return bool
     */
    public function omitTextualRepresentation(): bool;
}
