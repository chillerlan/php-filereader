<?php
/**
 * Class Directory
 *
 * @filesource   Directory.php
 * @created      03.03.2017
 * @package      chillerlan\Filereader
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\Filereader;

use chillerlan\Filereader\Drivers\FSDriverInterface;

/**
 *
 */
class Directory extends FSAbstract{

	/**
	 * Directory constructor.
	 *
	 * @param \chillerlan\Filereader\Drivers\FSDriverInterface $driver
	 * @param string                                           $path
	 */
	public function __construct(FSDriverInterface $driver, string $path){
		$this->filereader = $driver;
		$this->path       = $path;
	}

	/**
	 * @param string $path
	 *
	 * @return \chillerlan\Filereader\Directory
	 */
	public function change(string $path):Directory{
		$this->path = $path;

		return $this;
	}

	/**
	 * Reads a directory and returns the contents as an array of \stdClass
	 *
	 * @return array
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function read():array{

		if(!$this->filereader->isDir($this->path)){
			throw new FilereaderException('Directory not found: '.$this->path);
		}

		$dir = scandir($this->path);

		$filelist = [];

		if(is_array($dir)){

			foreach($dir as $file){

				if(in_array($file, ['.', '..'], true)){
					continue;
				}

				$filelist[] = new File($this->filereader, $this, $file);
			}
		}

		return $filelist;
	}

	/**
	 * @param string|null $subdir
	 *
	 * @return bool
	 */
	public function create(string $subdir = null):bool{

		if($subdir && $this->filereader->isDir($this->path)){
			return $this->filereader->makeDir($this->path.DIRECTORY_SEPARATOR.$subdir);
		}

		return $this->filereader->makeDir($this->path);
	}

	/**
	 * @param string|null $subdir
	 *
	 * @return bool
	 */
	public function delete(string $subdir = null):bool{

		if($subdir && $this->filereader->isDir($this->path)){
			return $this->filereader->deleteDir($this->path.DIRECTORY_SEPARATOR.$subdir);
		}

		return $this->filereader->deleteDir($this->path);
	}

	/**
	 * @param string $newname
	 * @param bool   $overwrite
	 *
	 * @return \chillerlan\Filereader\Directory
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function rename(string $newname, bool $overwrite = true):Directory{

		if(!$this->filereader->rename($this->path, $newname, $overwrite)){
			throw new FilereaderException('cannot rename '.$this->path.' to '.$newname); // @codeCoverageIgnore
		}

		return $this->change($newname);
	}

}
