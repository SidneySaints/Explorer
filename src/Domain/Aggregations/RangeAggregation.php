<?php

namespace JeroenG\Explorer\Domain\Aggregations;

use Webmozart\Assert\Assert;

class RangeAggregation implements AggregationSyntaxInterface
{

    public const RELATIONS = ['from', 'to'];

    private string $field;

    private ?float $boost;

    private array $ranges = [];

    public function __construct(string $field, ?float $boost = 1.0)
    {
        $this->field = $field;
        $this->boost = $boost;
    }

    public function build(): array
    {
        return [
            'range' => [
                'field' => $this->field,
                'ranges' => $this->ranges
            ]
        ];
    }

    public function addRange(array $definition)
    {
        $this->ranges[] = $definition;
    }

   
}
