<?php
declare(strict_types=1);

namespace Fiskalizacija\Sale;

use Fiskalizacija\Exceptions\BadRequestException;
use Fiskalizacija\Interfaces\Configuration;
use Fiskalizacija\Interfaces\Item;
use Fiskalizacija\Interfaces\Payment;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

abstract class Sale extends Request
{

    /**
     * @const string
     */
    const URI = '/v3/invoices';

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
     * @param Payment[] $payments
     * @param string $cashierId
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
     * @throws BadRequestException
     * @throws GuzzleException
     */
    public function run(): Response
    {
        $client = new Client();
        $response = $client->post($this->configuration->baseUrl() . self::URI, [
            RequestOptions::HEADERS => $this->headers(),
            RequestOptions::JSON => $this->requestBody()
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new BadRequestException();
        }

        return $this->response($response);
    }

    /**
     * @return array
     */
    private function headers(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'RequestId' => $this->requestUuid,
            'Accept-Language' => $this->configuration->language(),
            'PAC' => $this->configuration->pac(),
        ];
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
