# chillerlan/php-filereader
A simple file/directory reader for all (well, most... ok. some.) of your file-reading needs.

[![version][packagist-badge]][packagist]
[![license][license-badge]][license]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]
[![Scrunitizer][scrutinizer-badge]][scrutinizer]
[![Packagist downloads][downloads-badge]][downloads]
[![PayPal donate][donate-badge]][donate]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-filereader.svg?style=flat-square
[packagist]: https://packagist.org/packages/chillerlan/php-filereader
[license-badge]: https://img.shields.io/github/license/chillerlan/php-filereader.svg?style=flat-square
[license]: https://github.com/chillerlan/php-filereader/blob/master/LICENSE
[travis-badge]: https://img.shields.io/travis/chillerlan/php-filereader.svg?style=flat-square
[travis]: https://travis-ci.org/chillerlan/php-filereader
[coverage-badge]: https://img.shields.io/codecov/c/github/chillerlan/php-filereader.svg?style=flat-square
[coverage]: https://codecov.io/github/chillerlan/php-filereader
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/chillerlan/php-filereader.svg?style=flat-square
[scrutinizer]: https://scrutinizer-ci.com/g/chillerlan/php-filereader
[downloads-badge]: https://img.shields.io/packagist/dt/chillerlan/php-filereader.svg?style=flat-square
[downloads]: https://packagist.org/packages/chillerlan/database/stats
[donate-badge]: https://img.shields.io/badge/donate-paypal-ff33aa.svg?style=flat-square
[donate]: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WLYUNAT9ZTJZ4

# Requirements
- PHP 7+

# Documentation

## Installation
**requires [composer](https://getcomposer.org)**

### *composer.json*
 (note: replace `dev-master` with a [version boundary](https://getcomposer.org/doc/articles/versions.md#summary))
```json
{
	"require": {
		"php": ">=7.2.0",
		"chillerlan/database": "dev-master"
	}
}
```

### Manual installation
Download the desired version of the package from [master](https://github.com/chillerlan/php-filereader/archive/master.zip) or 
[release](https://github.com/chillerlan/php-filereader/releases) and extract the contents to your project folder. After that:
  - run `composer install` to install the required dependencies and generate `/vendor/autoload.php`.
  - if you use a custom autoloader, point the namespace `chillerlan\Filereader` to the folder `src` of the package 

Profit!

## Usage
### simple
You can just invoke one a `FSDriverInterface` and use it right away:

```php
use chillerlan\Filereader\Drivers\DiskDriver;

$filereader = new DiskDriver;
$filereader->isDir('/some/path');

```

### advanced
```php
$directory = new Directory($filereader, '/some/path');

/** @var \chillerlan\Filereader\File $file */
foreach($directory->read() as $file){
	echo $file->name;
	// ...
}

```

## API
### `FSDriverInterface` methods
method | return 
------ | ------
`fileExists(string $path)` | bool
`isFile(string $path)` | bool
`fileContents(string $path)` | string
`getRequire(string $path)` | mixed
`deleteFile(string $path)` | bool
`copyFile(string $source, string $destination, bool $overwrite = true)` | bool
`isDir(string $path)` | bool
`makeDir(string $path)` | bool
`deleteDir(string $path)` | bool
`rename(string $oldname, string $newname, bool $overwrite = true)` | bool

### `Directory` public methods
method | return 
------ | ------
`__construct(FSDriverInterface $driver, string $path)` | -
`change(string $path)` | `Directory`
`read()` | array of `File` objects
`create(string $subdir = null)` | bool
`delete(string $subdir = null)` | bool
`rename(string $newname, bool $overwrite = true)` | `Directory`

### `File` public methods
method | return 
------ | ------
`__construct(FSDriverInterface $driver, Directory $directory, string $name)` | -
`exists()` | bool
`content()` | string
`getRequire()` | mixed
`copy(string $destination, bool $overwrite = true)` | bool
`rename(string $newname, bool $overwrite = true)` | `File`
`delete()` | bool

### common magic properties of `Directory` and `File`
property | type | description
-------- | ---- | ----------- 
`$path` | string | the full path to the resource

### additional magic properties of `File`
property | type | description
-------- | ---- | ----------- 
`$name` | string | the basename of the file
`$directory` | `Directory` | the `Directory` which contains the file
