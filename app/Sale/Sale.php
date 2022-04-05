<?php
declare(strict_types=1);

namespace Fiskalizacija\Sale;

use DateTime;
use Exception;
use Fiskalizacija\Entities\Configuration;
use Fiskalizacija\Entities\Item;
use Fiskalizacija\Invoice\Properties;
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
     * @return Properties
     * @throws GuzzleException
     * @throws Exception
     */
    public function run(): Properties
    {
        $client = new Client();
        $response = $client->post($this->configuration->apiUrl(), [
            RequestOptions::CERT    => $this->configuration->certs(),
            RequestOptions::HEADERS => $this->configuration->headers($this->requestUuid),
            RequestOptions::JSON    => $this->requestBody()
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception($response->getBody()->getContents());
        }

        return $this->response($this, $response);
    }

    /**
     * @param Request $request
     * @param ResponseInterface $responseInterface
     * @return Properties
     * @throws Exception
     */
    private function response(Request $request, ResponseInterface $responseInterface): Properties
    {
        $response = json_decode($responseInterface->getBody()->getContents());
        return new Properties($request, $response);
    }
}
