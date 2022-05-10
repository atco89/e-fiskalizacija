<?php
declare(strict_types=1);

namespace TaxCore\Response;

use TaxCore\Entities\ApiRequestInterface;
use TaxCore\Entities\ConfigurationInterface;
use TaxCore\Entities\Enums\InvoiceType;
use TaxCore\Entities\Enums\TransactionType;
use TaxCore\Receipt\ReceiptBuilder;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class ResponseBuilder
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
     * @var ApiRequestInterface
     */
    private ApiRequestInterface $request;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var ReceiptBuilder
     */
    private ReceiptBuilder $receipt;

    /**
     * @param ConfigurationInterface $configuration
     * @param Environment $twig
     * @param ApiRequestInterface $request
     * @param Response $response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __construct(
        ConfigurationInterface $configuration,
        Environment            $twig,
        ApiRequestInterface    $request,
        Response               $response
    )
    {
        $this->configuration = $configuration;
        $this->twig = $twig;
        $this->request = $request;
        $this->response = $response;
        $this->title = $this->title();
        $this->receipt = new ReceiptBuilder($this->title, $this->generateReceipt());
    }

    /**
     * @return string
     */
    private function title(): string
    {
        $invoiceType = match ($this->request->invoiceType()) {
            InvoiceType::NORMAL   => 'промет',
            InvoiceType::PROFORMA => 'предрачун',
            InvoiceType::COPY     => 'копија',
            InvoiceType::TRAINING => 'обука',
            InvoiceType::ADVANCE  => 'аванс',
        };
        $transactionType = $this->request->transactionType() === TransactionType::SALE ? 'продаја' : 'рефундација';
        return implode(' - ', [$invoiceType, $transactionType]);
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
            'title'         => $this->title,
            'configuration' => $this->configuration,
            'request'       => $this->request,
            'response'      => $this->response,
        ]);
    }

    /**
     * @return ApiRequestInterface
     */
    public function getRequest(): ApiRequestInterface
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

    /**
     * @return ReceiptBuilder
     */
    public function getReceipt(): ReceiptBuilder
    {
        return $this->receipt;
    }
}
