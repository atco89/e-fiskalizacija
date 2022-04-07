<?php
declare(strict_types=1);

namespace Fiskalizacija\Sale;

use DateTime;
use Exception;
use Fiskalizacija\Entities\Configuration;
use Fiskalizacija\Entities\Item;
use Fiskalizacija\Entities\Merchant;
use Fiskalizacija\Entities\Payment;
use Fiskalizacija\Exceptions\TaxCoreRequestException;
use Fiskalizacija\Invoice\Properties;
use Fiskalizacija\Twig\Twig;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Sale extends Request
{

    /**
     * @var Configuration
     */
    protected Configuration $configuration;

    /**
     * @var Twig
     */
    private Twig $twig;

    /**
     * @param Configuration $configuration
     * @param string $requestId
     * @param string $invoiceNumber
     * @param DateTime $dateAndTimeOfIssue
     * @param Item[] $items
     * @param Payment[] $payments
     * @param string $cashier
     */
    public function __construct(
        Configuration $configuration,
        string        $requestId,
        string        $invoiceNumber,
        DateTime      $dateAndTimeOfIssue,
        array         $items,
        array         $payments,
        string        $cashier
    )
    {
        parent::__construct($requestId, $invoiceNumber, $dateAndTimeOfIssue, $items, $payments, $cashier);
        $this->configuration = $configuration;
        $this->twig = new Twig($this->configuration);
    }

    /**
     * @return string
     * @throws GuzzleException|LoaderError|RuntimeError|SyntaxError|TaxCoreRequestException
     */
    public function run(): string
    {
        $guzzleClient = new Client();
        $response = $guzzleClient->post($this->configuration->apiUrl(), [
            RequestOptions::CERT    => $this->configuration->certs(),
            RequestOptions::HEADERS => $this->configuration->headers($this->requestId),
            RequestOptions::JSON    => $this->requestBody()
        ]);

        if ($response->getStatusCode() === 200) {
            return $this->response($this->configuration->merchant(), $this, $response);
        }

        throw new TaxCoreRequestException();
    }

    /**
     * @param Merchant $merchant
     * @param Request $request
     * @param ResponseInterface $responseInterface
     * @return string
     * @throws LoaderError|RuntimeError|SyntaxError|Exception
     */
    private function response(Merchant $merchant, Request $request, ResponseInterface $responseInterface): string
    {
        $response = new Response(json_decode($responseInterface->getBody()->getContents()));
        return $this->twig->getEnvironment()->render('./invoice/index.html.twig', [
            'properties' => new Properties($merchant, $request, $response),
        ]);
    }
}
