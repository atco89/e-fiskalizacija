<?php
declare(strict_types=1);

namespace Fiskalizacija\Twig;

use Fiskalizacija\Entities\Configuration;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

final class Twig
{

    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $fileSystemLoader = new FilesystemLoader(__DIR__ . '/../../resources/views');
        $this->environment = new Environment($fileSystemLoader, ['cache' => false]);
        $this->environment->addGlobal('merchant_log_path', $configuration->merchantLogoPath());
        $this->environment->addFunction(new TwigFunction('decimal',
            function (?string $number, int $precision = 2) {
                return number_format(floatval($number), $precision, ',', '.');
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
