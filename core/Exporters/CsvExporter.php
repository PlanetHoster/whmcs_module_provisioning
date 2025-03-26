<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters;

class CsvExporter extends BaseExporter
{
    public function get(): string
    {
        $csvFile = $this->createTempFile();

        $headers = $this->dataSet->getHeaders();

        fputcsv($csvFile, $headers);

        foreach ($this->dataSet->getContentData() as $key => $item)
        {
            fputcsv($csvFile, $this->dataSet->getItemValuesByKey($key));
        }

        return $this->getContentFromTempFile($csvFile);
    }
}