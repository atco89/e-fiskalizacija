<?php
declare(strict_types=1);

namespace TaxCore\Entities\Request;

use TaxCore\Entities\ReferentDocumentInterface;

interface RequestWithReferentDocumentBuyerIdentifiedInterface
    extends RequestBuyerIdentifiedInterface, ReferentDocumentInterface
{

}
