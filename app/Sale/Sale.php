<?php
declare(strict_types=1);

namespace Fiskalizacija\Sale;

use DateTime;
use Exception;
use Fiskalizacija\Interfaces\Configuration;
use Fiskalizacija\Interfaces\Item;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

abstract class Sale extends Request
{

    /**
     * @var Configuration
     */
    protected Configuration $configuration;

    /**
     * @param Configuration $configuration
     * @param string $requestUuid
     * @param string $invoiceNumber
     * @param DateTime $dateAndTimeOfIssue
     * @param Item[] $items
     * @param array $payments
     * @param string $cashierId
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(
        Configuration $configuration,
        string        $requestUuid,
        string        $invoiceNumber,
        DateTime      $dateAndTimeOfIssue,
        array         $items,
        array         $payments,
        string        $cashierId
    )
    {
        parent::__construct($requestUuid, $invoiceNumber, $dateAndTimeOfIssue, $items, $payments, $cashierId);
        $this->configuration = $configuration;
    }

    /**
     * @return Response
     * @throws GuzzleException
     * @throws Exception
     */
    public function run(): Response
    {
        $client = new Client();
        $response = $client->post($this->configuration->apiUrl(), [
            RequestOptions::CERT    => $this->configuration->certs(),
            RequestOptions::HEADERS => $this->configuration->headers($this->requestUuid),
            RequestOptions::JSON    => $this->requestBody()
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Guzzle error');
        }

        return $this->response($response);
    }

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    private function response(ResponseInterface $response): Response
    {
        return new Response(json_decode($response->getBody()->getContents()));
    }
}
