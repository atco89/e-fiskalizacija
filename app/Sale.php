<?php
declare(strict_types=1);

namespace Fiskalizacija;

use Exception;
use Fiskalizacija\Exceptions\TaxCoreRequestException;
use Fiskalizacija\Interfaces\Configuration;
use Fiskalizacija\Interfaces\Invoice;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Sale extends Request
{

    /**
     * @var Twig
     */
    protected Twig $twig;

    /**
     * @var Configuration
     */
    protected Configuration $configuration;

    /**
     * @var Invoice
     */
    protected Invoice $invoice;

    /**
     * @param Configuration $configuration
     * @param Invoice $invoice
     */
    public function __construct(Configuration $configuration, Invoice $invoice)
    {
        parent::__construct($invoice);
        $this->invoice = $invoice;
        $this->configuration = $configuration;
        $this->twig = new Twig($configuration);
    }

    /**
     * @return string
     * @throws GuzzleException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TaxCoreRequestException
     */
    public function run(): string
    {
        $client = new Client();
        $response = $client->post($this->configuration->apiUrl(), $this->apiOptions());
        if ($response->getStatusCode() === 200) {
            return $this->response($this->invoice, $response);
        }
        throw new TaxCoreRequestException();
    }

    /**
     * @param Invoice $invoice
     * @param ResponseInterface $responseInterface
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    private function response(
        Invoice           $invoice,
        ResponseInterface $responseInterface
    ): string
    {
        $response = new Response(json_decode($responseInterface->getBody()->getContents()));
        $properties = new DocumentProperties($invoice, $response);
        return $this->twig->getEnvironment()->render('./invoice/index.html.twig', ['properties' => $properties]);
    }
}
