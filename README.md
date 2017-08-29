## Imgr

First version of Imgr - Version `0.1`

## Example

This project has an example which contains a simple api and ajax js script. Running example will render a simple form that takes a url, on submission it displays a waiting message and then renders images below once done
```
Api endpoint /rest/rest-api.php

Params - url = [Url]

Method Type - POST
```

## Documentation

Initialising the Imgr class
```PHP
$imgr = Imgr::forge($url, ImgrInterface $callback, $class, $background);
```
So the above constructor takes 4 parameters, but only 1 is required which is the $url the other optional are as follows:

This is a callback which is of type ImgrInterface (See below the functions)
```PHP
ImgrInterface $callback
```
A class name that finds images with a specific class attached to it
```PHP
String $class
```
If true will extract background images aswell, default is false
```PHP
Boolean $background
```

## Available Functions

### build
The first function to call after initialising the Class is the build function
```PHP
Imgr::forge('https://example.com/blog/article-1')->build();
```
The build function makes the call to the page and extracts the images

### getImages
After calling the build function, you will want to render the data which you do using the getImages function
```PHP
$images = Imgr::forge('https://example.com/blog/article-1', null, 'article__image', true)->build()->getImages();
```
This returns an object that contains an array of images, notice also the passing of the article__image class and scraping background images aswell

### ImgrInterface Callback
The callback has 3 functions, onImage, onComplete and onError
```PHP
class ImgrCallback implements ImgrInterface {
  
  public function onImage (ImgrImage $image) {
    // ImgrImage object
  }
  
  public function onComplete () {
    // called once all extracting of images are complete
  }
  
  public function onError ($failed) {
    // if error occurrs then will return here
  }
  
}
```
The first function is `onImage` which is called every image it finds. The second is `onComplete` which is called once the extraction of images is complete and `onError` pretty self explanatory
