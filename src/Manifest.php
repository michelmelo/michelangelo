<?php

namespace Michelmelo\Michelangelo;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage as IlluminateStorage;

class Manifest
{
    /**
     * @var array
     */
    protected $manifest = [];

    const FILENAME = 'michelangelo-manifest.json';

    /**
     * @param Dimensions $dimensions
     */
    public function __construct(Dimensions $dimensions)
    {
        $this->dimensions = $dimensions;

        $this->manifest = $this->load();
    }

    protected function load(): array
    {
        if (IlluminateStorage::disk('local')->has(self::FILENAME)) {
            return json_decode(IlluminateStorage::disk('local')->get(self::FILENAME), true);
        }

        return [];
    }

    protected function save()
    {
        IlluminateStorage::disk('local')->put(self::FILENAME, json_encode($this->manifest));
    }

    /**
     * @param string $image
     * @param string $dimension
     * @param string $optimized_image
     * @param string $format
     * @param int $quality
     */
    public function update(string $image, string $dimension, string $optimized_image, string $format, int $quality)
    {
        $this->manifest[$image][$dimension] = [
            "src"     => $optimized_image,
            "format"  => $format,
            "quality" => $quality,
            "width"   => $this->dimensions->getWidth($dimension),
            "height"  => $this->dimensions->getHeight($dimension),
        ];

        $this->save();
    }

    /**
     * @param string $image
     * @param string $dimension
     */
    public function delete(string $image, string $dimension)
    {
        unset($this->manifest[$image][$dimension]);

        $this->save();
    }

    /**
     * @param string $image
     * @param string $dimension
     * @return mixed
     */
    public function get(string $image, string $dimension = null)
    {
        if (is_null($dimension)) {
            if (!array_key_exists($image, $this->manifest)) {
                return null;
            }

            return $this->manifest[$image];
        }

        if (!array_key_exists($image, $this->manifest) or !array_key_exists($dimension, $this->manifest[$image])) {
            return null;
        }

        return $this->manifest[$image][$dimension];
    }
}
