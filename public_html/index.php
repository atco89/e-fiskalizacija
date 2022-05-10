<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Examples\Configuration;
use TaxCore\Request;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

$items = include __DIR__ . '/../app/Examples/data/items.php';
$buyerId = include __DIR__ . '/../app/Examples/data/buyer-id.php';
$buyerCostCenterId = include __DIR__ . '/../app/Examples/data/buyer-cost-center-id.php';
$advanceSale = include __DIR__ . '/../app/Examples/data/advance-sale.php';

try {
    $request = new Request(new Configuration());

    // ===== NORMAL SALE =====

    $n1 = $request->normalSale($items);
    saveOne($n1);

    $n2 = $request->normalSaleBuyerAndCostCenterIdentified(
        $items,
        $buyerId,
        $buyerCostCenterId,
    );
    saveOne($n2);

    $n3 = $request->normalSaleRefund(
        $items,
        $n1->getResponse()->invoiceNumber(),
        $n1->getResponse()->sdcDateTime(),
    );
    saveAll($n3);

    $n4 = $request->normalSaleBuyerIdentifiedRefund(
        $items,
        $n2->getResponse()->invoiceNumber(),
        $n2->getResponse()->sdcDateTime(),
        $buyerId,
    );
    saveAll($n4);

    // ===== ADVANCE SALE =====

    $a1 = $request->advanceSale(
        $items,
        $advanceSale['taxRateLabel'],
        floatval($advanceSale['amount']),
    );
    saveOne($a1);

    $a2 = $request->advanceSaleBuyerIdentified(
        $items,
        $advanceSale['taxRateLabel'],
        floatval($advanceSale['amount']),
        $buyerId,
    );
    saveOne($a2);

    // ===== CLOSE ADVANCE SALE =====

    $n5 = $request->normalSaleWithClosingAdvanceSale(
        $items,
        $a1->getResponse()->invoiceNumber(),
        $a1->getResponse()->sdcDateTime(),
        $advanceSale['taxRateLabel'],
        floatval($advanceSale['amount']),
    );
    saveAll($n5);

    $n6 = $request->normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        $items,
        $a2->getResponse()->invoiceNumber(),
        $a2->getResponse()->sdcDateTime(),
        $advanceSale['taxRateLabel'],
        floatval($advanceSale['amount']),
        $buyerId,
    );
    saveAll($n6);

    // ===== COPY SALE =====

    $c1 = $request->copySale(
        $items,
        $n1->getResponse()->invoiceNumber(),
        $n1->getResponse()->sdcDateTime(),
    );
    saveOne($c1);

    $c3 = $request->copySaleRefund(
        $items,
        $n1->getResponse()->invoiceNumber(),
        $n1->getResponse()->sdcDateTime(),
    );
    saveOne($c3);
} catch (Exception $e) {
    die($e->getMessage());
}

/**
 * @param ResponseBuilder $builder
 * @throws Exception
 */
function saveOne(ResponseBuilder $builder): void
{
    $basePath = __DIR__ . "/../resources/receipts";
    $directoryName = directoryName($builder->getRequest());
    if (!file_exists("$basePath/$directoryName")) {
        mkdir("$basePath/$directoryName", 0777, true);
    }

    $file = fopen("$basePath/$directoryName/{$builder->getResponse()->invoiceNumber()}.html", 'w');
    fwrite($file, $builder->getReceipt()->receipt());
    fclose($file);
}

/**
 * @param ApiRequestInterface $request
 * @return string
 * @throws Exception
 */
function directoryName(ApiRequestInterface $request): string
{
    $transactionType = $request->transactionType() === TransactionType::SALE ? 'prodaja' : 'refundacija';
    $invoiceType = match ($request->invoiceType()) {
        InvoiceType::NORMAL  => 'promet',
        InvoiceType::ADVANCE => 'avans',
        InvoiceType::COPY    => 'kopija',
        default              => throw new Exception('Unexpected match value'),
    };
    return implode('-', [$invoiceType, $transactionType]);
}

/**
 * @param ResponsesBuilder $builder
 * @throws Exception
 */
function saveAll(ResponsesBuilder $builder): void
{
    saveOne($builder->getFirstInvoice());
    saveOne($builder->getSecondInvoice());
}
