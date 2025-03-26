<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters;

use ModulesGarden\PlanetHoster\Core\Exporters\Source\DataModelInterface;

abstract class BaseExporter
{
    protected DataModelInterface $dataSet;

    public abstract function get(): string;

    public function __construct(DataModelInterface $dataSet)
    {
        $this->dataSet = $dataSet;
    }

    public function setHeaders(array $headers)
    {
        $this->dataSet->setCustomHeaders($headers);
    }

    public function write(\SplFileInfo $fileInfo)
    {
        $filePath = $fileInfo->getPathname();
        $file = new \SplFileObject($filePath, 'w');

        if (!$file->isWritable()) {
            throw new \Exception("File: $filePath is not writable");
        }

        $file->fwrite($this->get());
        $file = null;
    }

    protected function createTempFile()
    {
        if (!($csvFile = tmpfile()))
        {
            throw new \Exception('Create temporary file failure');
        }

        return $csvFile;
    }

    protected function getContentFromTempFile($csvFile):string
    {
        rewind($csvFile);

        $tmpFilePath = stream_get_meta_data($csvFile)['uri'];
        return file_get_contents($tmpFilePath);
    }
}