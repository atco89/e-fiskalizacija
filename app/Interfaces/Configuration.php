<?php
declare(strict_types=1);

namespace Fiskalizacija\Interfaces;

interface Configuration
{

    /**
     * @return string
     */
    public function baseUrl(): string;

    /**
     * @return string
     */
    public function token(): string;

    /**
     * @return string
     */
    public function uid(): string;

    /**
     * @return string
     */
    public function password(): string;

    /**
     * @return string
     */
    public function pac(): string;

    /**
     * @return string
     */
    public function language(): string;
}
