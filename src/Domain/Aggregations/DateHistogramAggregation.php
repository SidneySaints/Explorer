<?php

namespace JeroenG\Explorer\Domain\Aggregations;


final class DateHistogramAggregation implements AggregationSyntaxInterface
{


    private string $timezone;
    private string $interval;
    private string $field;
    private array $options;
    private array $aggregations = [];

    public function __construct(string $field, string $timezone, array $options = [])
    {
        $this->field = $field;
        $this->options = $options;
        $this->timezone = $timezone;
    }

    public function add(string $name, AggregationSyntaxInterface $agg): void
    {
        $this->aggregations[$name] = $agg;
    }

    public function build(): array
    {
        $query =  [
            "date_histogram" => array_merge([
                "min_doc_count" => 0,
                "field" => $this->field,
                "time_zone" => $this->timezone,
            ], $this->options),

        ];

        if(count($this->aggregations)){
            $query = array_merge($query,[
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
