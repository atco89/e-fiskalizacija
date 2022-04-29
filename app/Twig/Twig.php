<?php
declare(strict_types=1);

namespace TaxCore\Twig;

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
     * @construct
     */
    public function __construct()
    {
        $this->environment = new Environment(new FilesystemLoader(__DIR__ . '/../../resources/views'));
        $this->environment->addFilter(new TwigFilter('base64_encode',
            function (string|null $image): string {
                return base64_encode($image);
            }
        ));
        $this->environment->addFilter(new TwigFilter('image64',
            function (string|null $encodedImage, string $type): string {
                return implode(', ', ["data:image/$type;base64", $encodedImage]);
            }
        ));
        $this->environment->addFilter(new TwigFilter('decimal',
            function (string|null $number, int $precision = 2): string {
                $formattedNumber = empty($number) ? 0.00 : floatval($number);
                return number_format($formattedNumber, $precision, ',', '.');
            }
        ));
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }
}
