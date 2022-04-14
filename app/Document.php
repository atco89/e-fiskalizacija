<?php
declare(strict_types=1);

namespace TaxCore;

use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\RequestInterface as Request;
use TaxCore\Entities\Tax;
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
     * @var string
     */
    private string $documentTitle;

    /**
     * @var float
     */
    private float $taxAmount;

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
        $this->documentTitle = $this->title();
        $this->taxAmount = $this->taxAmount();
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
        if (empty($this->response->taxItems())) {
            return 0.00;
        }

        return array_reduce($this->response->taxItems(), function (?float $carry, Tax $tax): float {
            $carry += $tax->amount();
            return $carry;
        });
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
            'request'  => $this->request,
            'response' => $this->response,
        ]);
    }
}