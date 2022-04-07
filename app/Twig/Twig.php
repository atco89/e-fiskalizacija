<?php
declare(strict_types=1);

namespace Fiskalizacija\Twig;

use Fiskalizacija\Entities\Configuration;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

final class Twig
{

    /**
     * @const string
     */
    const FILE_SYSTEM_LOADER_PATH = __DIR__ . '/../../resources/views';

    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->environment = new Environment(new FilesystemLoader(self::FILE_SYSTEM_LOADER_PATH));
        $this->environment->addGlobal('merchant_log_path', $configuration->merchantLogoPath());
        $this->environment->addFilter(new TwigFilter('decimal',
            function (?string $number, int $precision = 2) {
                $number = empty($number) ? 0.00 : floatval($number);
                return number_format($number, $precision, ',', '.');
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
