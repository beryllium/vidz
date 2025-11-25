<?php

namespace src;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class EncoreHelper extends AbstractExtension implements GlobalsInterface
{
    protected $sourceDir;
    protected $manifest;

    public function __construct(string $sourceDir, string $manifest) {
        $this->sourceDir = $sourceDir;
        $this->manifest = $manifest;
    }

    public function getGlobals(): array
    {
        $manifestContents = file_get_contents($this->sourceDir . DIRECTORY_SEPARATOR . $this->manifest);

        if (!$manifestContents) {
            throw new \RuntimeException('Webpack Encore manifest file was not found');
        }

        $manifest = json_decode($manifestContents, JSON_OBJECT_AS_ARRAY);

        return [
            'webpack_manifest' => $manifest,
        ];
    }
}