<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Examples\Configuration;
use TaxCore\Request;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

try {
    $request = new Request(new Configuration());

    // ===== NORMAL SALE =====

    $n1 = $request->normalSale('');
    saveOne($n1);

    $n2 = $request->normalSaleBuyerAndCostCenterIdentified(
        '',
        '',
        ''
    );
    saveOne($n2);

    $n3 = $request->normalSaleRefund(
        '',
        '',
        ''
    );
    saveOne($n3);

    $n4 = $request->normalSaleBuyerIdentifiedRefund(
        '',
        '',
        '',
        ''
    );
    saveOne($n4);

    // ===== ADVANCE SALE =====

    $a1 = $request->advanceSale(
        '',
        ''
    );
    saveOne($a1);

    $a2 = $request->advanceSaleBuyerIdentified(
        '',
        '',
        ''
    );
    saveOne($a2);

    $a3 = $request->advanceSaleRefund(
        '',
        '',
        '',
        ''
    );
    saveOne($a3);

    $a4 = $request->advanceSaleBuyerIdentifiedRefund(
        '',
        '',
        '',
        '',
        ''
    );
    saveOne($a4);

    // ===== CLOSE ADVANCE SALE =====

    $n5 = $request->normalSaleWithClosingAdvanceSale(
        '',
        '',
        '',
        ''
    );
    saveAll($n5);

    $n6 = $request->normalSaleBuyerIdentifiedWithClosingAdvanceSale(
        '',
        '',
        '',
        '',
        ''
    );
    saveAll($n6);

    // ===== COPY SALE =====

    $c1 = $request->copySale(
        '',
        '',
        ''
    );
    saveOne($c1);

    $c2 = $request->copySaleBuyerIdentifiedBuilder(
        '',
        '',
        '',
        ''
    );
    saveOne($c2);

    $c3 = $request->copySaleRefund(
        '',
        '',
        '',
        ''
    );
    saveOne($c3);

    $c4 = $request->copySaleBuyerIdentifiedRefund(
        '',
        '',
        '',
        ''
    );
    saveOne($c4);
} catch (Exception $e) {
    die($e->getMessage());
}

/**
 * @param ResponseBuilder $builder
 */
function saveOne(ResponseBuilder $builder): void
{
    $file = fopen(__DIR__ . "/../resources/receipts/{$builder->getResponse()->invoiceNumber()}.html", 'w');
    fwrite($file, $builder->getReceipt()->receipt());
    fclose($file);
}

/**
 * @param ResponsesBuilder $builder
 */
function saveAll(ResponsesBuilder $builder): void
{
    saveOne($builder->getFirstInvoice());
    saveOne($builder->getSecondInvoice());
}
