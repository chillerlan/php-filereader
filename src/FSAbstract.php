<?php
/**
 * Class FSAbstract
 *
 * @filesource   FSAbstract.php
 * @created      06.03.2017
 * @package      chillerlan\Filereader
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\Filereader;

/**
 * @property string $path
 */
abstract class FSAbstract{

	/**
	 * @var \chillerlan\Filereader\Drivers\FSDriverInterface
	 */
	protected $filereader;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get(string $name){

		if(property_exists($this, $name) && $name !== 'filereader'){
			return $this->{$name};
		}

		return false;
	}

	/**
	 * @return array
	 */
	public function info():array {
		return pathinfo($this->path);
	}

	/**
	 * @param string $newname
	 * @param bool   $overwrite
	 *
	 * @return \chillerlan\Filereader\Directory|\chillerlan\Filereader\File
	 */
	abstract public function rename(string $newname, bool $overwrite = true);

}
