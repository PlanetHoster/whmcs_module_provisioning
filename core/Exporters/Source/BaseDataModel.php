<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters\Source;

class BaseDataModel
{
    protected array $customHeaders = [];

    public function setCustomHeaders(array $headers)
    {
        $this->customHeaders = $headers;
    }

    protected function combineHeaders(array $headers): array
    {
        return array_map(function($value){
            return $this->customHeaders[$value] ?: $value;
        }, $headers);
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