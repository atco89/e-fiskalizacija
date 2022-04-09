<?php
declare(strict_types=1);

namespace Fiskalizacija\Domain;

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
