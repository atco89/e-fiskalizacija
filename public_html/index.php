<?php
declare(strict_types=1);

use TaxCore\Examples\Configuration\Cashier;
use TaxCore\Examples\Configuration\Configuration;
use TaxCore\Examples\Configuration\Merchant;
use TaxCore\Examples\Request\RequestBuilder;
use TaxCore\Exceptions\TaxCoreRequestException;
use TaxCore\Request;

require_once __DIR__ . '/../vendor/autoload.php';

unset($_SESSION);

$merchant = new Merchant();
$samples = [
    'promet–prodaja.php'                        => 'promet–prodaja',
    'promet–prodaja-sa-identifikacijom.php'     => 'promet–prodaja-sa-identifikacijom',
    'avans–prodaja.php'                         => 'avans–prodaja',
    'avans–prodaja-sa-identifikacijom.php'      => 'avans–prodaja-sa-identifikacijom',
    'kopija–prodaja.php'                        => 'kopija–prodaja',
    'kopija–prodaja-sa-identifikacijom.php'     => 'kopija–prodaja-sa-identifikacijom',
    'avans–refundacija.php'                     => 'avans–refundacija',
    'avans–refundacija-sa-identifikacijom.php'  => 'avans–refundacija-sa-identifikacijom',
    'promet–refundacija.php'                    => 'promet–refundacija',
    'promet–refundacija-sa-identifikacijom.php' => 'promet–refundacija-sa-identifikacijom',
    'kopija–refundacija.php'                    => 'promet–refundacija',
    'kopija–refundacija-sa-identifikacijom.php' => 'promet–refundacija-sa-identifikacijom',
];
try {
    foreach ($samples as $sample => $reference) {
        $samplePath = __DIR__ . '/../app/Examples/Samples/' . $sample;
        $request = new Request(new Configuration());
        $responseBuilder = $request->run(new RequestBuilder($merchant, new Cashier(), include $samplePath));
        $response = $responseBuilder->getResponse();
        $receipt = $responseBuilder->getReceipt();

        if (!empty($reference)) {
            $_SESSION[$reference]['refDocumentNumber'] = $response->invoiceNumber();
            $_SESSION[$reference]['refDocumentDateTime'] = serialize($response->sdcDateTime());
        }

        $file = fopen(__DIR__ . '/../resources/output/' . $response->invoiceNumber() . '.html', 'w');
        fwrite($file, $receipt);
        fclose($file);

        sleep(30);
    }
} catch (TaxCoreRequestException | Error | Exception $e) {
    die($e->getMessage());
}
