<?php
declare(strict_types=1);

namespace TaxCore\Twig;

use TaxCore\Entities\MerchantInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

final class Twig
{

    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @param MerchantInterface $merchant
     */
    public function __construct(MerchantInterface $merchant)
    {
        $this->environment = new Environment(new FilesystemLoader(__DIR__ . '/../../resources/views'));
        $this->environment->addFilter(new TwigFilter('merchant_log_path', function () use ($merchant): string {
            return base64_encode(file_get_contents($merchant->logoPath()));
        }));
        $this->environment->addFilter(new TwigFilter('decimal', function (?string $number, int $precision = 2) {
            $formattedNumber = empty($number) ? 0.00 : floatval($number);
            return number_format($formattedNumber, $precision, ',', '.');
        }));
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }
}
