<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Entities\ReferentDocumentInterface;
use TaxCore\Examples\Configuration;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;
use TaxCore\Response\Response;

$cashier = 'Petar Petrović';
$items = include __DIR__ . '/../app/Examples/data/items.php';
$payment = include __DIR__ . '/../app/Examples/data/payment.php';
$refundPayment = include __DIR__ . '/../app/Examples/data/payment-refund.php';
$advancePayment = include __DIR__ . '/../app/Examples/data/advance-payment.php';
$buyer = include __DIR__ . '/../app/Examples/data/buyer.php';
$buyerCostCenter = include __DIR__ . '/../app/Examples/data/buyer-cost-center.php';
$referentDocument = include __DIR__ . '/../app/Examples/data/referent-document.php';

try {
    $request = new Request(new Configuration());

    /** NORMAL SALE */
    $normalSale = $request->normalSale($cashier, $items, $payment);
    save($normalSale->getResponse()->invoiceNumber(), $normalSale->getReceipt()->receipt());

    /** NORMAL SALE CUSTOMER IDENTIFIED */
    $normalSaleCustomerIdentified = $request->normalSaleCustomerIdentified(
        $cashier,
        $items,
        $payment,
        $buyer,
        $buyerCostCenter
    );
    save(
        $normalSaleCustomerIdentified->getResponse()->invoiceNumber(),
        $normalSaleCustomerIdentified->getReceipt()->receipt()
    );

    /** NORMAL SALE REFUND */
    $normalSaleRefund = $request->normalSaleRefund(
        $cashier,
        $items,
        $refundPayment,
        referentDocument($normalSale->getResponse())
    );
    save($normalSaleRefund->getResponse()->invoiceNumber(), $normalSaleRefund->getReceipt()->receipt());

    /** NORMAL SALE REFUND CUSTOMER IDENTIFIED */
    $normalSaleRefundCustomerIdentified = $request->normalSaleRefundCustomerIdentified(
        $cashier,
        $items,
        $refundPayment,
        referentDocument($normalSaleCustomerIdentified->getResponse()),
        $buyer
    );
    save(
        $normalSaleRefundCustomerIdentified->getResponse()->invoiceNumber(),
        $normalSaleRefundCustomerIdentified->getReceipt()->receipt()
    );

    /** ADVANCE SALE */
    $advanceSale = $request->advanceSale($cashier, $items, $advancePayment);
    save($advanceSale->getResponse()->invoiceNumber(), $advanceSale->getReceipt()->receipt());

    /** ADVANCE SALE CUSTOMER IDENTIFIED */
    $advanceSaleCustomerIdentified = $request->advanceSaleCustomerIdentified($cashier, $items, $advancePayment, $buyer);
    save(
        $advanceSaleCustomerIdentified->getResponse()->invoiceNumber(),
        $advanceSaleCustomerIdentified->getReceipt()->receipt()
    );

    /** ADVANCE SALE REFUND */
    $advanceSaleRefund = $request->advanceSaleRefund(
        $cashier,
        $items,
        $advancePayment,
        referentDocument($advanceSale->getResponse())
    );
    save(
        $advanceSaleRefund->getResponse()->invoiceNumber(),
        $advanceSaleRefund->getReceipt()->receipt()
    );

    /** ADVANCE SALE REFUND CUSTOMER IDENTIFIED */
    $advanceSaleRefundCustomerIdentified = $request->advanceSaleRefundCustomerIdentified(
        $cashier,
        $items,
        $advancePayment,
        referentDocument($advanceSaleCustomerIdentified->getResponse()),
        $buyer
    );
    save(
        $advanceSaleRefundCustomerIdentified->getResponse()->invoiceNumber(),
        $advanceSaleRefundCustomerIdentified->getReceipt()->receipt()
    );

    /** COPY SALE */
    $copySale = $request->copySale($cashier, $items, $payment, referentDocument($normalSale->getResponse()));
    save($copySale->getResponse()->invoiceNumber(), $copySale->getReceipt()->receipt());

    /** COPY SALE CUSTOMER IDENTIFIED */
    $copySaleCustomerIdentified = $request->copySaleCustomerIdentified(
        $cashier,
        $items,
        $payment,
        referentDocument($normalSaleCustomerIdentified->getResponse()),
        $buyer
    );
    save(
        $copySaleCustomerIdentified->getResponse()->invoiceNumber(),
        $copySaleCustomerIdentified->getReceipt()->receipt()
    );

    /** COPY SALE REFUND */
    $copySaleRefund = $request->copySaleRefund(
        $cashier,
        $items,
        $refundPayment,
        referentDocument($copySale->getResponse())
    );
    save($copySaleRefund->getResponse()->invoiceNumber(), $copySaleRefund->getReceipt()->receipt());

    /** COPY SALE REFUND CUSTOMER IDENTIFIED */
    $copySaleRefundCustomerIdentified = $request->copySaleRefundCustomerIdentified(
        $cashier,
        $items,
        $refundPayment,
        referentDocument($copySaleRefund->getResponse()),
        $buyer
    );
    save(
        $copySaleRefundCustomerIdentified->getResponse()->invoiceNumber(),
        $copySaleRefundCustomerIdentified->getReceipt()->receipt()
    );
} catch (TaxCoreRequestException $e) {
    die($e->getMessage());
}

/**
 * @param string $invoiceNumber
 * @param string $data
 */
function save(string $invoiceNumber, string $data): void
{
    $file = fopen(__DIR__ . "/../resources/output/$invoiceNumber.html", 'w');
    fwrite($file, $data);
    fclose($file);
}

/**
 * @param Response $response
 * @return ReferentDocumentInterface
 */
function referentDocument(Response $response): ReferentDocumentInterface
{
    return new class($response) implements ReferentDocumentInterface {

        /**
         * @var Response
         */
        private Response $response;

        /**
         * @param Response $response
         */
        public function __construct(Response $response)
        {
            $this->response = $response;
        }

        /**
         * @return string
         * @noinspection PhpPureAttributeCanBeAddedInspection
         */
        public function referentDocumentNumber(): string
        {
            return $this->response->invoiceNumber();
        }

        /**
         * @return DateTimeInterface
         */
        public function referentDocumentDateTime(): DateTimeInterface
        {
            return $this->response->sdcDateTime();
        }
    };
}
