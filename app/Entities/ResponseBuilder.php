<?php
declare(strict_types=1);

namespace TaxCore\Entities;

use DateTime;
use Exception;
use stdClass;

final class ResponseBuilder
{

    /**
     * @var stdClass
     */
    private stdClass $response;

    /**
     * @param stdClass $response
     */
    public function __construct(stdClass $response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function requestedBy(): string
    {
        return $this->response->requestedBy;
    }

    /**
     * @return string
     */
    public function signedBy(): string
    {
        return $this->response->signedBy;
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function sdcDateTime(): DateTime
    {
        return new DateTime($this->response->sdcDateTime);
    }

    /**
     * @return string
     */
    public function invoiceCounter(): string
    {
        return $this->response->invoiceCounter;
    }

    /**
     * @return string
     */
    public function invoiceCounterExtension(): string
    {
        return $this->response->invoiceCounterExtension;
    }

    /**
     * @return string
     */
    public function invoiceNumber(): string
    {
        return $this->response->invoiceNumber;
    }

    /**
     * @return string
     */
    public function verificationUrl(): string
    {
        return $this->response->verificationUrl;
    }

    /**
     * @return string
     */
    public function verificationQRCode(): string
    {
        return $this->response->verificationQRCode;
    }

    /**
     * @return string
     */
    public function journal(): string
    {
        return $this->response->journal;
    }

    /**
     * @return int
     */
    public function totalCounter(): int
    {
        return $this->response->totalCounter;
    }

    /**
     * @return int
     */
    public function transactionTypeCounter(): int
    {
        return $this->response->transactionTypeCounter;
    }

    /**
     * @return float
     */
    public function totalAmount(): float
    {
        return $this->response->totalAmount;
    }

    /**
     * @return string
     */
    public function encryptedInternalData(): string
    {
        return $this->response->encryptedInternalData;
    }

    /**
     * @return string
     */
    public function signature(): string
    {
        return $this->response->signature;
    }

    /**
     * @return TaxItemInterface[]
     */
    public function taxItems(): array
    {
        return array_map(function (stdClass $item): TaxItemInterface {
            return new class($item) implements TaxItemInterface {

                private stdClass $item;

                /**
                 * @param stdClass $item
                 */
                public function __construct(stdClass $item)
                {
                    $this->item = $item;
                }

                /**
                 * @return string
                 */
                public function label(): string
                {
                    return $this->item->label;
                }

                /**
                 * @return string
                 */
                public function name(): string
                {
                    return $this->item->categoryName;
                }

                /**
                 * @return int
                 */
                public function type(): int
                {
                    return $this->item->categoryType;
                }

                /**
                 * @return float
                 */
                public function rate(): float
                {
                    return $this->item->rate;
                }

                /**
                 * @return float
                 */
                public function amount(): float
                {
                    return $this->item->amount;
                }
            };
        }, $this->response->taxItems);
    }

    /**
     * @return string
     */
    public function businessName(): string
    {
        return $this->response->businessName;
    }

    /**
     * @return string
     */
    public function locationName(): string
    {
        return $this->response->locationName;
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return $this->response->address;
    }

    /**
     * @return string
     */
    public function tin(): string
    {
        return $this->response->tin;
    }

    /**
     * @return string
     */
    public function district(): string
    {
        return $this->response->district;
    }

    /**
     * @return int
     */
    public function taxGroupRevision(): int
    {
        return $this->response->taxGroupRevision;
    }

    /**
     * @return string
     */
    public function mrc(): string
    {
        return $this->response->mrc;
    }

    /**
     * @return string|null
     */
    public function messages(): ?string
    {
        return $this->response->messages;
    }
}