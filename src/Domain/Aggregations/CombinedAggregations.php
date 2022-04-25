<?php

namespace JeroenG\Explorer\Domain\Aggregations;

class CombinedAggregations implements AggregationSyntaxInterface
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

    public function build(): array
    {
        return array_merge(
            $this->agg->build(),
            ['aggs' => $this->buildNestedAggregations()]
        );
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
