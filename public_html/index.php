<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TaxCore\Examples\Configuration;
use TaxCore\Examples\Request\AdvanceSale;
use TaxCore\Examples\Request\AdvanceSaleBuyerIdentified;
use TaxCore\Examples\Request\AdvanceSaleBuyerIdentifiedRefund;
use TaxCore\Examples\Request\AdvanceSaleRefund;
use TaxCore\Examples\Request\CopySale;
use TaxCore\Examples\Request\CopySaleBuyerIdentified;
use TaxCore\Examples\Request\CopySaleRefund;
use TaxCore\Examples\Request\CopySaleRefundBuyerIdentified;
use TaxCore\Examples\Request\NormalSale;
use TaxCore\Examples\Request\NormalSaleBuyerAndCostCenterIdentified;
use TaxCore\Examples\Request\NormalSaleBuyerIdentifiedRefund;
use TaxCore\Examples\Request\NormalSaleRefund;
use TaxCore\Request;
use TaxCore\Response\ResponseBuilder;
use TaxCore\Response\ResponsesBuilder;

try {
    $request = new Request(new Configuration());

    // ===== NORMAL SALE =====

    $n1 = $request->normalSale(new NormalSale());
    saveOne($n1);

    $n2 = $request->normalSaleBuyerAndCostCenterIdentified(new NormalSaleBuyerAndCostCenterIdentified());
    saveOne($n2);

    $n3 = $request->normalSaleRefund(new NormalSaleRefund($n1->getResponse()));
    saveOne($n3);

    $n4 = $request->normalSaleBuyerIdentifiedRefund(new NormalSaleBuyerIdentifiedRefund($n2->getResponse()));
    saveOne($n4);

    // ===== ADVANCE SALE =====

    $a1 = $request->advanceSale(new AdvanceSale());
    saveOne($a1);

    $a2 = $request->advanceSaleBuyerIdentified(new AdvanceSaleBuyerIdentified());
    saveOne($a2);

    $a3 = $request->advanceSaleRefund(new AdvanceSaleRefund($a1->getResponse()));
    saveOne($a3);

    $a4 = $request->advanceSaleBuyerIdentifiedRefund(new AdvanceSaleBuyerIdentifiedRefund($a2->getResponse()));
    saveOne($a4);

    // ===== CLOSE ADVANCE SALE =====

//    $n5 = $request->normalSaleWithClosingAdvanceSale('', '');
//    saveAll($n5);
//
//    $n6 = $request->normalSaleBuyerIdentifiedWithClosingAdvanceSale('', '');
//    saveAll($n6);

    // ===== COPY SALE =====

    $c1 = $request->copySale(new CopySale($n1->getResponse()));
    saveOne($c1);

    $c2 = $request->copySaleBuyerIdentifiedBuilder(new CopySaleBuyerIdentified($n2->getResponse()));
    saveOne($c2);

    $c3 = $request->copySaleRefund(new CopySaleRefund($n3->getResponse()));
    saveOne($c3);

    $c4 = $request->copySaleRefundBuyerIdentified(new CopySaleRefundBuyerIdentified($n4->getResponse()));
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
    saveOne($builder->getAdvanceSale());
    saveOne($builder->getNormalSale());
}
