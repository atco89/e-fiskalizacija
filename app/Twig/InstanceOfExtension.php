<?php
declare(strict_types=1);

namespace TaxCore\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

final class InstanceOfExtension extends AbstractExtension
{

    /**
     * @return array
     */
    public function getTests(): array
    {
        return [
            new TwigTest('instanceof', [$this, 'isInstanceof']),
        ];
    }

    /**
     * @param mixed $variable
     * @param mixed $instance
     * @return bool
     */
    public function isInstanceof(mixed $variable, mixed $instance): bool
    {
        return $variable instanceof $instance;
    }
}