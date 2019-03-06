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

use chillerlan\Filereader\Drivers\FSDriverInterface;

/**
 * @property string $path
 */
abstract class FSAbstract implements FSInterface{

	/**
	 * @var \chillerlan\Filereader\Drivers\FSDriverInterface
	 */
	protected $filereader;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * FSAbstract constructor.
	 *
	 * @param \chillerlan\Filereader\Drivers\FSDriverInterface $driver
	 */
	public function __construct(FSDriverInterface $driver){
		$this->filereader = $driver;
	}

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function __get(string $name){

		if(property_exists($this, $name) && $name !== 'filereader'){
			return $this->{$name};
		}

		return null;
	}

	/**
	 * @return array
	 */
	public function info():array{
		return pathinfo($this->path);
	}

}
