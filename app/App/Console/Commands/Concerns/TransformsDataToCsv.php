<?php

namespace App\Console\Commands\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionParameter;
use Spatie\LaravelData\Data;

trait TransformsDataToCsv
{
    /**
     * @param  Collection<int, Model>  $datacollection
     */
    public function generateCsvFile(Collection $datacollection, string $dataClass, string $filename): void
    {
        $header = $this->getDataPropertiesFromClass($dataClass);

        $csvContent = $datacollection
            ->map(fn (Model $model) => $dataClass::from($model)->all())
            ->prepend($header)
            ->map(fn ($row) => $this->formatRow($row))
            ->implode("\n");

        Storage::put($filename, $csvContent);
    }

    /**
     * Extracts the property names from the constructor of a given Data class.
     *
     * @param  string  $dataClass  The fully qualified class name of a Data subclass.
     * @return array<int, string> A list of property names extracted from the constructor parameters.
     *
     * @todo : do better
     */
    private function getDataPropertiesFromClass(string $dataClass): array
    {
        // Ensure the class exists and is a valid subclass of Data
        if (! class_exists($dataClass) || ! is_subclass_of($dataClass, Data::class)) {
            throw new InvalidArgumentException("$dataClass must be a valid Data class.");
        }

        // Use reflection to analyze the class structure
        $reflection = new ReflectionClass($dataClass);

        // Get the constructor method
        $constructor = $reflection->getConstructor();

        // If no constructor is present, return an empty array (no properties to extract)
        if (! $constructor) {
            return [];
        }

        // Extract and return the property names from the constructor parameters
        return array_map(
            fn (ReflectionParameter $parameter) => $parameter->getName(),
            $constructor->getParameters()
        );
    }

    /**
     * @param  array<mixed>  $row
     */
    private function formatRow(array $row): string
    {
        foreach ($row as $value) {
            if (is_array($value)) {
                throw new InvalidArgumentException('Array values are not yet supported.');
            }
        }

        return implode(',', $row);
    }
}
