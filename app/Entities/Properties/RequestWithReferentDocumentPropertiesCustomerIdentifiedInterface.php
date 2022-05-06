<?php
declare(strict_types=1);

namespace TaxCore\Entities\Properties;

interface RequestWithReferentDocumentPropertiesCustomerIdentifiedInterface extends RequestWithReferentDocumentProperties
{

    /**
     * @return string
     */
    public function buyerId(): string;
}
