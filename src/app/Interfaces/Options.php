<?php
declare(strict_types=1);

namespace App\Interfaces;

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
