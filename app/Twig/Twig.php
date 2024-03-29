<?php
declare(strict_types=1);

namespace TaxCore\Twig;

use TaxCore\Entities\TaxItemInterface;
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

        $this->environment->addFilter(new TwigFilter('base64Encode',
            function (string|null $imagePath): string {
                return base64_encode(file_get_contents($imagePath));
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

        $this->environment->addFilter(new TwigFilter('taxAmount',
            function (array $items): float {
                return array_reduce($items, function (float|null $carry, TaxItemInterface $item): float {
                    $carry += $item->amount();
                    return $carry;
                });
            }
        ));

        $this->environment->addFilter(new TwigFilter('instanceof',
            function (mixed $variable, mixed $instance): bool {
                return $variable instanceof $instance;
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
