<?php
declare(strict_types=1);

namespace TaxCore;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\Request as RequestInterface;
use TaxCore\Entities\TaxItem;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Document
{

    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @param Environment $environment
     * @param RequestInterface $request
     * @param Response $response
     */
    public function __construct(Environment $environment, RequestInterface $request, Response $response)
    {
        $this->environment = $environment;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function receipt(): string
    {
        return $this->environment->render('./receipt/index.html.twig', [
            'request'   => $this->request,
            'response'  => $this->response,
            'title'     => $this->title(),
            'taxAmount' => $this->taxAmount(),
        ]);
    }

    /**
     * @return string
     */
    private function title(): string
    {
        $invoiceType = $this->request->invoiceType();
        if ($this->request->transactionType() === TransactionType::SALE) {
            return match ($invoiceType) {
                InvoiceType::NORMAL   => 'Промет - продаја',
                InvoiceType::PROFORMA => 'Предрачун - продаја',
                InvoiceType::COPY     => 'Копија - продаја',
                InvoiceType::TRAINING => 'Обука - продаја',
                InvoiceType::ADVANCE  => 'Аванс - продаја',
            };
        }
        return match ($invoiceType) {
            InvoiceType::NORMAL   => 'Промет - рефундација',
            InvoiceType::PROFORMA => 'Предрачун - рефундација',
            InvoiceType::COPY     => 'Копија - рефундација',
            InvoiceType::TRAINING => 'Обука - рефундација',
            InvoiceType::ADVANCE  => 'Аванс - рефундација',
        };
    }

    /**
     * @return float
     */
    private function taxAmount(): float
    {
        return array_reduce($this->response->taxItems(), function (?float $carry, TaxItem $tax): float {
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
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}