<?php
declare(strict_types=1);

namespace App\Sale;

use App\Constants\TransactionType;
use App\Interfaces\Item;
use App\Interfaces\Options;
use App\Interfaces\Payment;
use DateTime;

abstract class Request
{

    /**
     * @var string
     */
    protected string $requestUuid;
    /**
     * Interfaces Type enumeration value: 0 - Normal, 1 - Proforma, 2 - Copy, 3 - Training, 4 - Advance
     *
     * @return int
     */
    protected int $invoiceType;
    /**
     * Transaction Type enumeration
     * 0 - Sale
     * 1 - Refund
     *
     * @return int
     */
    protected int $transactionType = TransactionType::SALE;
    /**
     * Cost Center ID provided by the buyer to the cashier in case Buyer’s company wants to track spending in
     * Taxpayer Portal. It is optional and may exist only for B2B transactions; otherwise, it shall be ignored by E-SDC.
     *
     * @return string|null
     */
    protected ?string $buyerCostCenterId = null;
    /**
     * Mandatory only in case Interfaces Type is Refund, Copy or Normal Sale connected to an Advance Sale. In all cases,
     * this field must contain Interfaces Number of previously issued invoice. In any other case this field is optional.
     * ASCII, in the requestedBy-signedBy- Ordinal_Number format. Unicode MaxLength : 50
     *
     * @return string|null
     */
    protected ?string $referentDocumentNumber = null;
    /**
     * SDC Date and time of the document referenced in referentDocumentDT field.
     * It is used to calculate taxes on the date of issue of the original document that is refunded or copied.
     *
     * @return string|null
     */
    protected ?string $referentDocumentDT = null;
    /**
     * Interfaces number generated by a POS.
     *
     * @return string|null
     */
    private string $invoiceNumber;
    /**
     * Current Local Date and Time in ISO 8601 format.
     *
     * @return DateTime
     */
    private DateTime $dateAndTimeOfIssue;
    /**
     * Each invoice contains at least one Item in Items collection
     * (E-SDC should support minimum 250, recommended up to 500)
     *
     * @return Item[]
     */
    private array $items;
    /**
     * List of Payments for the invoice, where each Payment defines its method and amount
     *
     * @return Payment[]
     */
    private array $payments;
    /**
     * Cashier’s identification.
     *
     * @return string
     */
    private string $cashierId;
    /**
     * Taxpayer ID of the Buyer. It is mandatory for B2B transactions; otherwise, it's optional.
     *
     * @return string|null
     */
    private ?string $buyerId;

    /**
     * @param string $requestUuid
     * @param string $invoiceNumber
     * @param DateTime $dateAndTimeOfIssue
     * @param Item[] $items
     * @param Payment[] $payments
     * @param string $cashierId
     * @param string|null $buyerId
     */
    public function __construct(
        string   $requestUuid,
        string   $invoiceNumber,
        DateTime $dateAndTimeOfIssue,
        array    $items,
        array    $payments,
        string   $cashierId,
        ?string  $buyerId = null
    )
    {
        $this->requestUuid = $requestUuid;
        $this->invoiceNumber = $invoiceNumber;
        $this->dateAndTimeOfIssue = $dateAndTimeOfIssue;
        $this->items = $items;
        $this->payments = $payments;
        $this->cashierId = $cashierId;
        $this->buyerId = $buyerId;
    }

    /**
     * @return string[]
     */
    protected function requestBody(): array
    {
        return [
            'dateAndTimeOfIssue' => $this->dateAndTimeOfIssue->format(DATE_ISO8601),
            'invoiceType' => $this->invoiceType,
            'transactionType' => $this->transactionType,
            'payment' => $this->payments(),
            'cashier' => $this->cashierId,
            'buyerId' => $this->buyerId,
            'buyerCostCenterId' => $this->buyerCostCenterId,
            'invoiceNumber' => $this->invoiceNumber,
            'referentDocumentNumber' => $this->referentDocumentNumber,
            'referentDocumentDT' => $this->referentDocumentDT,
            'items' => $this->items(),
            'options' => [
                'OmitQRCodeGen' => intval($this->options()->omitQRCodeGen()),
                'OmitTextualRepresentation' => intval($this->options()->omitTextualRepresentation()),
            ],
        ];
    }

    /**
     * List of Payments for the invoice, where each Payment defines its method and amount
     *
     * @return Payment[]
     */
    private function payments(): array
    {
        return array_map(function (Payment $payment): array {
            return [
                'amount' => $payment->amount(),
                'paymentType' => $payment->paymentType(),
            ];
        }, $this->payments);
    }

    /**
     * Each invoice contains at least one Item in Items collection
     * (E-SDC should support minimum 250, recommended up to 500)
     *
     * @return Item[]
     */
    private function items(): array
    {
        return array_map(function (Item $item): array {
            return [
                'gtin' => $item->globalTradeItemNumber(),
                'name' => $item->name(),
                'quantity' => $item->quantity(),
                'unitPrice' => $item->price(),
                'labels' => $item->labels(),
                'totalAmount' => $item->amount(),
            ];
        }, $this->items);
    }

    /**
     * Key/value collection defines the output of E-SDC invoice fiscalization, to optimize resources. Key: OmitQRCodeGen
     * Key: OmitQRCodeGen
     * Value: "1" to omit QR Code generation by E-SDC and "0" to generate and return QR code.
     * Key: OmitTextualRepresentation
     * Value: "1" to omit generation of textual representation by E-SDC and "0" to generate
     * return textual representation to POS.
     *
     * @return Options
     */
    private function options(): Options
    {
        return new class implements Options {

            /**
             * @return bool
             */
            public function omitQRCodeGen(): bool
            {
                return false;
            }

            /**
             * @return bool
             */
            public function omitTextualRepresentation(): bool
            {
                return false;
            }
        };
    }
}
