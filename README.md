# Michelangelo

Michelangelo is a Laravel Image Management and Optimization Package. Define image dimensions and options, store uploaded image in multiple dimensions with or without a watermark and retrieve optimized images on your website when needed.

## Overview


### Benefits

You can keep your original user uploaded images untouched (2MB or more). This package will create new optimized images and keep reference of the original and optimized in the manifest file.

Your page will load faster because it will have less MB to download because the images will be smaller. I have managed to reduce image size from 2.4MB to 700Kb, just by implementing this package as an addon later in the development phase.



## Installation

From the command line:

```bash
composer require michelmelo/michelangelo
```

Publish the config file `michelangelo.php` to your `/config` directory:

```bash
php artisan vendor:publish --provider="Michelmelo\Michelangelo\ServiceProvider" --tag=config
```

Installation complete!

## Configuration

Before continuing be sure to open the `/config/michelangelo.php` file and update the dimensions and quality to your needs.



### Store method

After you have stored the user uploaded image in your storage `UploadedFile $image->store('images')` and you have retrieved the path to the image. Give that path (that you would usually store in the database) to michelangelo:

```php
use Michelmelo\Michelangelo\Michelangelo;

public function store(Request $request, Michelangelo $michelangelo)
{
    // ...

    // store original image in storage
    $article->image = $request->image->store('images');

    // optimize original image to desired dimensions
    $michelangelo->optimize($article->image, ['news', 'news_cover']);

    // ...
}
```


### Update method

When the user is going to replace the existing image with a new one, we have to first purge all records from storage and manifest file of the old image and then optimize the new image:

```php
use Michelmelo\Michelangelo\Michelangelo;

public function update(Request $request, Article $article, Michelangelo $michelangelo)
{
    // ...

    if ($request->hasFile('image')) {

        // delete original image from storage
        Storage::delete($article->image);

        // delete all optimized images for old image
        $michelangelo->drop($article->image, ['news', 'news_cover']);

        // save new original image to storage and retrieve the path
        $article->image = $request->image->store('images');

        // optimize new original image
        $michelangelo->optimize($article->image, ['news', 'news_cover']);
    }

    // ...
}
```



### Destroy method

When deleting a record which has optimized images, be sure to delete optimized image also to reduce unused files:

```php
use Michelmelo\Michelangelo\Michelangelo;


public function destroy(Article $article, Michelangelo $michelangelo)
{
    // ...

    // delete original image
    Storage::delete($article->image);

    // delete optimized images
    $michelangelo->purge($article->image);

    // delete record from database
    $article->delete();

    // ...
}
```


### Retrieving optimized images

From your view files do:

```blade
<image src="{{ Michelangelo::get($article->image, 'news') }}" />
```
This line will retrieve the optimized image URL.



## Sponsors & Backers


## Contributing


## Code of Conduct


## License

Michelangelo is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
