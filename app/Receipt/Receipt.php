<?php
declare(strict_types=1);

namespace TaxCore\Receipt;

use TaxCore\Entities\ReceiptInterface;

final class Receipt implements ReceiptInterface
{

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $receipt;

    /**
     * @param string $title
     * @param string $receipt
     */
    public function __construct(string $title, string $receipt)
    {
        $this->title = $title;
        $this->receipt = $receipt;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function receipt(): string
    {
        return $this->receipt;
    }
}
