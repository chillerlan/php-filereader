<?php
/**
 * Interface FSInterface
 *
 * @filesource   FSInterface.php
 * @created      06.03.2019
 * @package      chillerlan\Filereader
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\Filereader;

interface FSInterface{

	/**
	 * @param string $name
	 *
	 * @return mixed|null
	 */
	public function __get(string $name);

	/**
	 * @return array
	 */
	public function info():array;

	/**
	 * @param string $newname
	 * @param bool   $overwrite
	 *
	 * @return \chillerlan\Filereader\Directory|\chillerlan\Filereader\File
	 */
	public function rename(string $newname, bool $overwrite = true);

}
