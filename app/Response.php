<?php
declare(strict_types=1);

namespace TaxCore;

use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\CustomerSignatureInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Entities\RequestInterface;
use TaxCore\Response\ResponseBuilder;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Response
{

    /**
     * @var ConfigurationInterface
     */
    private ConfigurationInterface $configuration;

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
     * @param ConfigurationInterface $configuration
     * @param Environment $twig
     * @param RequestInterface $request
     * @param ResponseBuilder $response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __construct(
        ConfigurationInterface $configuration,
        Environment            $twig,
        RequestInterface       $request,
        ResponseBuilder        $response
    )
    {
        $this->configuration = $configuration;
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
            'configuration'               => $this->configuration,
            'title'                       => $this->title(),
            'request'                     => $this->request,
            'response'                    => $this->response,
            'instanceOfCustomerSignature' => $this->request instanceof CustomerSignatureInterface,
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
