<?php

namespace Dan\Shopify\Helpers;

use Dan\Shopify\Shopify;

/**
 * Class Endpoint
 *
 * @method array|\Illuminate\Support\Collection all(array $query, string $append = '')
 * @method integer count(array $query = [], $append = '')
 * @method array delete(array $query = [], string $append = '')
 * @method bool destroy(AbstractModel $model)
 * @method string endpoint(...$args)
 * @method AbstractModel find(string $id)
 * @method array|\Illuminate\Support\Collection findMany(array $ids, string $append = '')
 * @method array get(array $query = [], string $append = '')
 * @method array|AbstractModel post(array $payload = [], string $append = '')
 * @method array|AbstractModel put(array $payload = [], string $append = '')
 * @method AbstractModel save(AbstractModel $model, $append = '')
 * @property string endpoint
 * @property array ids
 */
abstract class Endpoint
{
    /** @var Shopify $api */
    protected $api;

    /**
     * Endpoint constructor.
     *
     * @param Shopify $api
     */
    public function __construct(Shopify $api)
    {
        $this->api = $api;
    }

    /**
     * Set our endpoint by accessing it via a property.
     *
     * @param  string $property
     * @return $this
     */
    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }

        return $this->api->__get($property);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }

        return $this->api->$method(...$parameters);
    }
}
