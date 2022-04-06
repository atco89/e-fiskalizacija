<?php
declare(strict_types=1);

namespace Fiskalizacija\Twig;

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
     * @construct
     */
    public function __construct()
    {
        $this->environment = new Environment(new FilesystemLoader(__DIR__ . '/../../resources/views'), ['cache' => false]);
        $this->setupFunctions($this->environment);
    }

    /**
     * @param Environment $environment
     * @return void
     */
    private function setupFunctions(Environment $environment): void
    {
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
