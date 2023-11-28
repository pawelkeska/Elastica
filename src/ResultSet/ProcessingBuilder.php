<?php

namespace Elastica\ResultSet;

use Elastic\Elasticsearch\Response\Elasticsearch;
use Elastica\Query;
use Elastica\ResultSet;

class ProcessingBuilder implements BuilderInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    public function __construct(BuilderInterface $builder, ProcessorInterface $processor)
    {
        $this->builder = $builder;
        $this->processor = $processor;
    }

    /**
     * Runs any registered transformers on the ResultSet before
     * returning it, allowing the transformers to inject additional
     * data into each Result.
     */
    public function buildResultSet(Elasticsearch $response, Query $query): ResultSet
    {
        $resultSet = $this->builder->buildResultSet($response, $query);

        $this->processor->process($resultSet);

        return $resultSet;
    }
}
