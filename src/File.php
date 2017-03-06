<?php
/**
 * Class File
 *
 * @filesource   File.php
 * @created      03.03.2017
 * @package      chillerlan\Filereader
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\Filereader;

use chillerlan\Filereader\Drivers\FSDriverInterface;

/**
 * @property string $name
 * @property \chillerlan\Filereader\Directory $directory
 */
class File extends FSAbstract{

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var \chillerlan\Filereader\Directory
	 */
	protected $directory;

	/**
	 * File constructor.
	 *
	 * @param \chillerlan\Filereader\Drivers\FSDriverInterface $driver
	 * @param \chillerlan\Filereader\Directory                 $directory
	 * @param string                                           $name
	 */
	public function __construct(FSDriverInterface $driver, Directory $directory, string $name){
		$this->filereader = $driver;
		$this->directory  = $directory;
		$this->name       = $name;
		$this->path       = $this->directory->path.DIRECTORY_SEPARATOR.$this->name;
	}

	/**
	 * @return bool
	 */
	public function exists():bool{
		return $this->filereader->fileExists($this->path);
	}

	/**
	 * @return string
	 */
	public function content():string{
		return $this->filereader->fileContents($this->path);
	}

	/**
	 * @return mixed
	 */
	public function getRequire(){
		return $this->filereader->getRequire($this->path);
	}

	/**
	 * @param string $destination
	 * @param bool   $overwrite
	 *
	 * @return bool
	 */
	public function copy(string $destination, bool $overwrite = true):bool{
		return $this->filereader->copyFile($this->path, $destination, $overwrite);
	}

	/**
	 * @param string $newname
	 * @param bool   $overwrite
	 *
	 * @return \chillerlan\Filereader\File
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function rename(string $newname, bool $overwrite = true):File{

		if(!$this->filereader->rename($this->path, $newname, $overwrite)){
			throw new FilereaderException('cannot rename '.$this->path.' to '.$newname); // @codeCoverageIgnore
		}

		if(!$this->filereader->isFile($newname)){
			throw new FilereaderException('file not found: '.$newname); // @codeCoverageIgnore
		}

		$this->path = $newname;

		$info = pathinfo($this->path);

		$this->name  = isset($info['filename']) ? $info['filename'] : '';
		$this->name .= '.'.$info['extension'];
		$this->directory = new Directory($this->filereader, $info['dirname']);

		return $this;
	}

	/**
	 * @return bool
	 */
	public function delete():bool{
		return $this->filereader->deleteFile($this->path);
	}

}
