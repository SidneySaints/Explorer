<?php

namespace JeroenG\Explorer\Domain\Aggregations;

class RawAggregation implements AggregationSyntaxInterface
{
    private array $query = [];

    public function __construct(array $query)
    {
    }

    public function build(): array
    {
        return $this->query;
    }
}
