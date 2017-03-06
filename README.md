# codemasher/php-filereader

[![version][packagist-badge]][packagist]
[![license][license-badge]][license]
[![Travis][travis-badge]][travis]
[![Coverage][coverage-badge]][coverage]
[![Scrunitizer][scrutinizer-badge]][scrutinizer]
[![Code Climate][codeclimate-badge]][codeclimate]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-filereader.svg
[packagist]: https://packagist.org/packages/chillerlan/php-filereader
[license-badge]: https://img.shields.io/packagist/l/chillerlan/php-filereader.svg
[license]: https://github.com/codemasher/php-filereader/blob/master/LICENSE
[travis-badge]: https://img.shields.io/travis/codemasher/php-filereader.svg
[travis]: https://travis-ci.org/codemasher/php-filereader
[coverage-badge]: https://img.shields.io/codecov/c/github/codemasher/php-filereader.svg
[coverage]: https://codecov.io/github/codemasher/php-filereader
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/codemasher/php-filereader.svg
[scrutinizer]: https://scrutinizer-ci.com/g/codemasher/php-filereader
[codeclimate-badge]: https://img.shields.io/codeclimate/github/codemasher/php-filereader.svg
[codeclimate]: https://codeclimate.com/github/codemasher/php-filereader

##Info

A simple file/directory reader for all (well, most...) of your file-reading needs.

## Requirements
- PHP 7+

## Documentation

### Installation
#### Using [composer](https://getcomposer.org)

*Terminal*
```sh
composer require chillerlan/php-filereader:dev-master
```

*composer.json*
```json
{
	"require": {
		"php": ">=7.0.3",
		"chillerlan/php-filereader": "dev-master"
	}
}
```

#### Manual installation
Download the desired version of the package from [master](https://github.com/codemasher/php-filereader/archive/master.zip) or 
[release](https://github.com/codemasher/php-filereader/releases) and extract the contents to your project folder. 
Point the namespace `chillerlan\Filereader` to the folder `src` of the package.

Profit!

### Usage
#### simple
You can just invoke one a `FSDriverInterface` and use it right away:

```php
use chillerlan\Filereader\Drivers\DiskDriver;

$filereader = new DiskDriver;
$filereader->isDir('/some/path');

```

#### advanced
```php
$directory = new Directory($filereader, '/some/path');

/** @var \chillerlan\Filereader\File $file */
foreach($directory->read() as $file){
	echo $file->name;
	// ...
}

```
