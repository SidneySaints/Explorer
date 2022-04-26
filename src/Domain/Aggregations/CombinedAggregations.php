<?php

namespace JeroenG\Explorer\Domain\Aggregations;

use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;

class CombinedAggregations implements AggregationSyntaxInterface
{

    private array $aggregations = [];


    public function add(string $name, AggregationSyntaxInterface $agg): void
    {
        $this->aggregations[$name] = $agg;
    }

    public function build(): array
    {
        return [
            "aggs" => $this->buildNestedAggregations()
        ];
    }

    private function buildNestedAggregations(): array
    {
        $data = [];
        foreach ($this->aggregations as $name => $aggregation) {
            $data[$name] = $aggregation->build();
        }
        return $data;
    }
}
