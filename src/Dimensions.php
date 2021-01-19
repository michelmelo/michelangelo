<?php

namespace Michelmelo\Michelangelo;

use Illuminate\Support\Arr;

class Dimensions
{
    /**
     * @var mixed
     */
    protected $collection;

    public function __construct()
    {
        $this->collection = config('michelangelo.dimensions');
    }

    /**
     * Check if the dimension exists in the config.
     *
     * @param string|array $dimension
     * @throws \Exception
     * @return null
     */
    public function hasOrFail($dimension)
    {
        if (!Arr::has($this->collection, $dimension)) {
            throw new \Exception('Dimension not valid. Check `config/michelangelo.php` for supported dimensions.');
        }
    }

    /**
     * @param $dimension
     */
    public function getWidth($dimension)
    {
        return Arr::get($this->collection, $dimension . '.width');
    }

    /**
     * @param $dimension
     */
    public function getHeight($dimension)
    {
        return Arr::get($this->collection, $dimension . '.height');
    }

    /**
     * @param $dimension
     */
    public function getQuality($dimension)
    {
        return Arr::get($this->collection, $dimension . '.quality');
    }

    /**
     * @param $dimension
     */
    public function getFormat($dimension)
    {
        return Arr::get($this->collection, $dimension . '.format');
    }

}
