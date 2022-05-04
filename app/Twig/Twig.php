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

        $this->environment->addFilter(new TwigFilter('delimiter',
            function (string|null $string): string {
                $size = empty($string) ? 41 : 39;
                $length = $size - mb_strlen($string, mb_detect_encoding($string));
                $spaces = empty($string) ? 0 : 1;
                $left = intval(ceil($length / 2) - $spaces);
                $showString = empty($string) ? $string : "<strong> $string </strong>";
                $right = intval($length - $left - $spaces);
                return implode('', [str_repeat('=', $left), $showString, str_repeat('=', $right)]);
            }
        ));

        $this->environment->addFilter(new TwigFilter('image64',
            function (string|null $encodedImage, string $type): string {
                return implode(', ', ["data:image/$type;base64", $encodedImage]) . PHP_EOL;
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
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }
}
