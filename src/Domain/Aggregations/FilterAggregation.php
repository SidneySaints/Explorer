<?php

namespace JeroenG\Explorer\Domain\Aggregations;

use JeroenG\Explorer\Domain\Syntax\SyntaxInterface;

class FilterAggregation implements AggregationSyntaxInterface
{


    private AggregationSyntaxInterface $agg;
    private array $aggregations = [];

    public function __construct(AggregationSyntaxInterface $agg)
    {
        $this->agg = $agg;
    }

    public function add(string $name, AggregationSyntaxInterface $agg): void
    {
        $this->aggregations[$name] = $agg;
    }

    private function buildNestedAggregations(): array
    {
        $data = [];
        foreach ($this->aggregations as $name => $aggregation) {
            $data[$name] = $aggregation->build();
        }
        return $data;
    }


    public function build(): array
    {
        $query = [
            "filter" => $this->agg->build(),
        ];

        if (count($this->aggregations)) {
            $query = array_merge($query, ['aggs' => $this->buildNestedAggregations()]);
        }
        return $query;
    }
}
