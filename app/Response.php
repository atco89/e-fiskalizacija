<?php
declare(strict_types=1);

namespace TaxCore;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\RequestInterface;
use TaxCore\Entities\ResponseBuilder;
use TaxCore\Entities\TaxItemInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Response
{

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var ResponseBuilder
     */
    private ResponseBuilder $response;

    /**
     * @var string
     */
    private string $receipt;

    /**
     * @param Environment $twig
     * @param RequestInterface $request
     * @param ResponseBuilder $response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __construct(Environment $twig, RequestInterface $request, ResponseBuilder $response)
    {
        $this->twig = $twig;
        $this->request = $request;
        $this->response = $response;
        $this->receipt = $this->generateReceipt();
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function generateReceipt(): string
    {
        return $this->twig->render('./receipt/index.html.twig', [
            'documentTitle' => $this->title(),
            'request'       => $this->request,
            'response'      => $this->response,
            'totalTax'      => $this->totalTax(),
        ]);
    }

    /**
     * @return string
     */
    private function title(): string
    {
        $invoiceType = match ($this->request->invoiceType()) {
            InvoiceType::NORMAL   => 'ПРОМЕТ',
            InvoiceType::PROFORMA => 'ПРЕДРАЧУН',
            InvoiceType::COPY     => 'КОПИЈА',
            InvoiceType::TRAINING => 'ОБУКА',
            InvoiceType::ADVANCE  => 'АВАНС',
        };
        $transactionType = $this->request->transactionType() === TransactionType::SALE ? 'ПРОДАЈА' : 'РЕФУНДАЦИЈА';
        return implode(' - ', [$invoiceType, $transactionType]);
    }

    /**
     * @return float
     */
    private function totalTax(): float
    {
        return array_reduce($this->response->taxItems(), function (?float $carry, TaxItemInterface $tax): float {
            $carry += $tax->amount();
            return $carry;
        });
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @return ResponseBuilder
     */
    public function getResponse(): ResponseBuilder
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getReceipt(): string
    {
        return $this->receipt;
    }
}
