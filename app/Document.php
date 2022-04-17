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
                InvoiceType::NORMAL   => 'Продаја',
                InvoiceType::PROFORMA => 'Проформа',
                InvoiceType::COPY     => 'Копија',
                InvoiceType::TRAINING => 'Обука',
                InvoiceType::ADVANCE  => 'Авансни рачун',
            };
        }
        return match ($invoiceType) {
            InvoiceType::NORMAL   => 'Продаја Рефундација',
            InvoiceType::PROFORMA => 'Проформа Рефундација',
            InvoiceType::COPY     => 'Копија Рефундација',
            InvoiceType::TRAINING => 'Обука Рефундација',
            InvoiceType::ADVANCE  => 'Аванс Рефундација',
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
     * @return Request
     */
    public function getRequest(): Request
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