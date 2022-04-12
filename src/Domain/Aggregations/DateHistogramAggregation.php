<?php

namespace JeroenG\Explorer\Domain\Aggregations;


final class DateHistogramAggregation implements AggregationSyntaxInterface
{


    private string $timezone;
    private string $interval;
    private string $field;
    private array $options;

    public function __construct(string $field, string $interval, string $timezone, array $options = [])
    {
        $this->field = $field;
        $this->interval = $interval;
        $this->options = $options;
        $this->timezone = $timezone;
    }

    public function build(): array
    {

        return [
            "date_histogram" => array_merge([
                "min_doc_count" => 0,
                "field" => $this->field,
                "fixed_interval" => $this->interval,
                "time_zone" => $this->timezone,
            ], $this->options)
        ];
    }
}
