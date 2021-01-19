<?php

namespace Michelmelo\Michelangelo;

use Intervention\Image\ImageManager;

class Engine
{
    /**
     * @var mixed
     */
    protected $manager;
    /**
     * @var mixed
     */
    protected $dimensions;

    /**
     * @var mixed
     */
    protected $quality;
    /**
     * @var mixed
     */
    protected $format;

    /**
     * @param ImageManager $manager
     * @param Dimensions $dimensions
     */
    public function __construct(ImageManager $manager, Dimensions $dimensions)
    {
        $this->manager    = $manager;
        $this->dimensions = $dimensions;

        $this->quality = config('michelangelo.quality');
        $this->format  = config('michelangelo.format');
    }

    /**
     * @param int $quality
     */
    public function setQuality(int $quality)
    {
        $this->quality = $quality;
    }

    /**
     * @param string $dimension
     * @return mixed
     */
    public function getQuality(string $dimension)
    {
        return $this->dimensions->getQuality($dimension) ?? $this->quality;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     * @param string $dimension
     * @return mixed
     */
    public function getFormat(string $dimension)
    {
        return $this->dimensions->getFormat($dimension) ?? $this->format;
    }

    /**
     * @param string $image
     * @param string $dimension
     * @return string
     */
    public function manipulate(string $image, string $dimension)
    {
        return $this->manager
            ->make($image)
            ->fit(
                $this->dimensions->getWidth($dimension),
                $this->dimensions->getHeight($dimension)
            )
            ->encode(
                $this->getFormat($dimension),
                $this->getQuality($dimension)
            )
            ->__toString();
    }
}
