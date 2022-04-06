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
        $this->environment = new Environment(new FilesystemLoader(__DIR__ . '/../../resources/views'), ['cache' => false]);
        $this->setupEnvironment($configuration, $this->environment);
    }

    /**
     * @param Configuration $configuration
     * @param Environment $environment
     * @return void
     */
    private function setupEnvironment(Configuration $configuration, Environment $environment): void
    {
        $environment->addGlobal('merchant_log_path', $configuration->merchantLogoPath());
        $environment->addFunction(new TwigFunction('decimal',
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
