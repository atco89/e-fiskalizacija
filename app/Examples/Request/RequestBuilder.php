<?php
declare(strict_types=1);

namespace TaxCore\Examples\Request;

use DateTime;
use Exception;
use Ramsey\Uuid\Uuid;
use TaxCore\Entities\CashierInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\ItemsInterface;
use TaxCore\Entities\MerchantInterface;
use TaxCore\Entities\PaymentInterface;
use TaxCore\Entities\RequestInterface;
use TaxCore\Examples\InvoiceNumber;
use TaxCore\Examples\Item\Items;
use TaxCore\Examples\Payment\Payment;

final class RequestBuilder implements RequestInterface
{

    /**
     * @var MerchantInterface
     */
    protected MerchantInterface $merchant;

    /**
     * @var CashierInterface
     */
    protected CashierInterface $cashier;

    /**
     * @var array
     */
    protected array $request;

    /**
     * @var DateTime
     */
    protected DateTime $issueDateTime;

    /**
     * @var string
     */
    protected string $requestId;

    /**
     * @param MerchantInterface $merchant
     * @param CashierInterface $cashier
     * @param array $request
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(MerchantInterface $merchant, CashierInterface $cashier, array $request)
    {
        $this->merchant = $merchant;
        $this->cashier = $cashier;
        $this->request = $request;
        $this->issueDateTime = new DateTime();
        $this->requestId = Uuid::uuid4()->toString();
    }

    /**
     * @return MerchantInterface
     */
    public function merchant(): MerchantInterface
    {
        return $this->merchant;
    }

    /**
     * @return CashierInterface
     */
    public function cashier(): CashierInterface
    {
        return $this->cashier;
    }

    /**
     * @return string
     */
    public function invoiceNumber(): string
    {
        $invoiceNumber = new InvoiceNumber($this->invoiceType(), $this->transactionType(), $this->issueDateTime());
        return $invoiceNumber->get();
    }

    /**
     * @return InvoiceType
     */
    public function invoiceType(): InvoiceType
    {
        return $this->request['invoiceType'];
    }

    /**
     * @return TransactionType
     */
    public function transactionType(): TransactionType
    {
        return $this->request['transactionType'];
    }

    /**
     * @return DateTime
     */
    public function issueDateTime(): DateTime
    {
        return $this->issueDateTime;
    }

    /**
     * @return string
     */
    public function requestId(): string
    {
        return $this->requestId;
    }

    /**
     * @return string|null
     */
    public function buyerId(): string|null
    {
        return $this->request['buyerId'];
    }

    /**
     * @return string|null
     */
    public function buyerCostCenterId(): string|null
    {
        return $this->request['buyerCostCenterId'];
    }

    /**
     * @return string|null
     */
    public function referentDocumentNumber(): string|null
    {
        return $this->request['referentDocumentNumber'];
    }

    /**
     * @return DateTime|null
     * @throws Exception
     */
    public function referentDocumentDateTime(): DateTime|null
    {
        return empty($this->request['referentDocumentDateTime'])
            ? null
            : $this->request['referentDocumentDateTime'];
    }

    /**
     * @return PaymentInterface
     */
    public function payments(): PaymentInterface
    {
        return new Payment($this->request['payment'], $this->request['advanceAccount'], $this->items());
    }

    /**
     * @return ItemsInterface
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function items(): ItemsInterface
    {
        return new Items($this->request['items']);
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return $this->items()->amount();
    }

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
        return true;
    }
}
