<?php

namespace Michelmelo\Michelangelo;

use Illuminate\Support\Facades\Storage as IlluminateStorage;

class Storage
{
    /**
     * Disk used for getting images.
     * Use `disk` to change the disk.
     */
    protected $disk;

    public function __construct()
    {
        $this->disk = config('michelangelo.disk');
    }

    /**
     * @param string $disk
     */
    public function disk(string $disk)
    {
        $this->disk = $disk;
    }

    /**
     * It gets the image content from the disk
     * where the originals are located.
     *
     * @param string $path
     */
    public function get($path)
    {
        return IlluminateStorage::disk($this->disk)->get($path);
    }

    /**
     * It saves the image to the specified disk or
     * to the default application disk.
     *
     * @param string $name
     * @param string $content
     * @param string|null $disk
     * @return null
     */
    public function put(string $name, string $content, $disk = null)
    {
        IlluminateStorage::disk($disk)->put($name, $content);
    }

    /**
     * @param $path
     * @param $disk
     */
    public function url($path, $disk = null)
    {
        return IlluminateStorage::disk($disk)->url($path);
    }

    /**
     * @param $path
     * @param $disk
     */
    public function delete($path, $disk = null)
    {
        IlluminateStorage::disk($disk)->delete($path);
    }
}
