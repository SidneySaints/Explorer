<?php

declare(strict_types=1);

namespace JeroenG\Explorer\Domain\Aggregations;

final class TermsAggregation implements AggregationSyntaxInterface
{
    private string $field;

    private int $size;

    private ?int $minDocCount;

    private array $aggregations = [];


    public function __construct(string $field, int $size = 10, int $minDocCount = null)
    {
        $this->field = $field;
        $this->size = $size;
        $this->minDocCount = $minDocCount;
    }

    public function add(string $name, AggregationSyntaxInterface $agg): void
    {
        $this->aggregations[$name] = $agg;
    }


    public function build(): array
    {
        $query = [
            'terms' => [
                'field' => $this->field,
                'size' => $this->size,

            ]
        ];

        if ($this->minDocCount) {
            $query = array_merge($query, ['min_doc_count' => $this->minDocCount]);
        }

        if (count($this->aggregations)) {
            $query = array_merge($query, [
                'aggs' => $this->buildNestedAggregations()
            ]);
        }

        return $query;
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
