<?php
declare(strict_types=1);

namespace TaxCore;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\RequestInterface as Request;
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
     * @var Request
     */
    private Request $request;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @param Environment $environment
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Environment $environment, Request $request, Response $response)
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
    public function generate(): string
    {
        return $this->environment->render('./invoice/index.html.twig', [
            'request'       => $this->request,
            'response'      => $this->response,
            'documentTitle' => $this->title(),
            'taxAmount'     => $this->taxAmount(),
        ]);
    }

    /**
     * @return string
     */
    private function title(): string
    {
        $invoiceType = $this->request->invoice()->invoiceType();
        if ($this->request->invoice()->transactionType() === TransactionType::SALE) {
            return match ($invoiceType) {
                InvoiceType::NORMAL   => 'Продаја',
                InvoiceType::PROFORMA => 'Проформа',
                InvoiceType::COPY     => 'Копија',
                InvoiceType::TRAINING => 'Обука',
                InvoiceType::ADVANCE  => 'Авансни рачун',
            };
        }
        return match ($invoiceType) {
            InvoiceType::NORMAL   => 'Продаја - Повраћај',
            InvoiceType::PROFORMA => 'Проформа - Повраћај',
            InvoiceType::COPY     => 'Копија - Повраћај',
            InvoiceType::TRAINING => 'Обука - Повраћај',
            InvoiceType::ADVANCE  => 'Авансни рачун - Повраћај',
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
}