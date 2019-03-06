<?php
/**
 * Interface FSDriverInterface
 *
 * @filesource   FSDriverInterface.php
 * @created      02.03.2017
 * @package      chillerlan\Filereader\Drivers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2016 Smiley
 * @license      MIT
 */

namespace chillerlan\Filereader\Drivers;

/**
 * @todo
 *
 * writeFile
 *
 */
interface FSDriverInterface{

	/**
	 * Checks if the given file exists.
	 *
	 * @param string $path the file path
	 *
	 * @return bool
	 */
	public function fileExists(string $path):bool;

	/**
	 * Checks if the given $path is a file.
	 *
	 * @param string $path the file path
	 *
	 * @return bool
	 */
	public function isFile(string $path):bool;

	/**
	 * Checks if the given $path is a directory.
	 *
	 * @param string $path the directory path
	 *
	 * @return bool
	 */
	public function isDir(string $path):bool;

	/**
	 * Returns the given file's contents
	 *
	 * @param string $path the file path
	 *
	 * @return string the file's contents
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function fileContents(string $path):string;

	/**
	 * Requires the given source file and returns it's executed contents.
	 * Caution! This is a potential security leak. You could eval() as well.
	 *
	 * @param string $path the file path
	 *
	 * @return mixed the file's executed contents
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function getRequire(string $path);

	/**
	 * Creates a new directory under $path.
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public function makeDir(string $path):bool;

	/**
	 * Deletes directory $path (if empty)
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public function deleteDir(string $path):bool;

	/**
	 * Deletes a file
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public function deleteFile(string $path):bool;

	/**
	 * Renames a file from $oldname to $newname
	 *
	 * @param string $oldname
	 * @param string $newname
	 * @param bool   $overwrite
	 *
	 * @return bool
	 */
	public function rename(string $oldname, string $newname, bool $overwrite = true):bool;

	/**
	 * Copies a file from $source to $dest
	 *
	 * @param string $source
	 * @param string $destination
	 * @param bool   $overwrite
	 *
	 * @return bool
	 */
	public function copyFile(string $source, string $destination, bool $overwrite = true):bool;

	/**
	 * @param string $path
	 * @param string $data
	 * @param bool   $overwrite
	 *
	 * @return int|bool
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function write(string $path, string $data, bool $overwrite = true);

	/**
	 * @param string $path
	 *
	 * @return int|null
	 */
	public function fileModifyTime(string $path):?int;

	/**
	 * @param string $path
	 *
	 * @return bool
	 * @throws \chillerlan\Filereader\FilereaderException
	 */
	public function isWritable(string $path):bool;
}
