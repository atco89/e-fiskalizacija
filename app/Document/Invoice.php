<?php
declare(strict_types=1);

namespace Fiskalizacija\Document;

use Dompdf\Dompdf;
use Dompdf\Options;

final class Invoice
{

    /**
     * @var array
     */
    private array $paperSize;

    /**
     * @var string
     */
    private string $orientation;

    /**
     * @var string
     */
    private string $documentContent;

    /**
     * @var Dompdf
     */
    private Dompdf $dompdf;

    /**
     * @param string $documentContent
     */
    public function __construct(string $documentContent)
    {
        $this->paperSize = [0, 0, 226.77, 999.99];
        $this->orientation = 'portrait';
        $this->documentContent = $documentContent;
        $this->dompdf = $this->loadDompdf();
    }

    /**
     * @return Dompdf
     */
    private function loadDompdf(): Dompdf
    {
        $dompdf = new Dompdf();

        $dompdf->setPaper($this->paperSize, $this->orientation);
        $dompdf->setOptions($this->options());
        $dompdf->loadHtml($this->documentContent);
        $dompdf->render();

        return $dompdf;
    }

    /**
     * @return Options
     */
    private function options(): Options
    {
        $options = new Options();

        $options->setIsJavascriptEnabled(true);
        $options->setIsHtml5ParserEnabled(true);
        $options->setIsRemoteEnabled(true);

        return $options;
    }

    /**
     * @return string|null
     */
    public function output(): ?string
    {
        return $this->dompdf->output();
    }
}
