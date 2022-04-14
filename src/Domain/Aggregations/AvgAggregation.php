<?php

namespace JeroenG\Explorer\Domain\Aggregations;

final class AvgAggregation implements AggregationSyntaxInterface
{
    private string $script;

    public function __construct(string $script)
    {
        $this->script = $script;
    }

    public function build(): array
    {
        return [
            'avg' => [
                "script" => "$this->script"
            ]
        ];
    }
}
