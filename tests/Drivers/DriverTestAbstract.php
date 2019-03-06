<?php
/**
 * Class DriverTestAbstract
 *
 * @filesource   DriverTestAbstract.php
 * @created      03.03.2017
 * @package      chillerlan\FilereaderTest\Drivers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\FilereaderTest\Drivers;

use chillerlan\Filereader\FilereaderException;
use PHPUnit\Framework\TestCase;

abstract class DriverTestAbstract extends TestCase{

	/**
	 * @var string
	 */
	protected $test_dir;

	/**
	 * @var \chillerlan\Filereader\Drivers\FSDriverInterface
	 */
	protected $filereader;

	/**
	 * @return array
	 */
	abstract public function fileDataProvider();
	abstract public function dirDataProvider();
	abstract public function fileContentDataProvider();
	abstract public function fileRequireDataProvider();
	abstract public function fileCopyDataProvider();
	abstract public function makeDirDataProvider();
	abstract public function deleteFileDataProvider();
	abstract public function renameFileDataProvider();
	abstract public function renameFileExceptionDataProvider();
	abstract public function writeDataProvider();

	/**
	 * @dataProvider fileDataProvider
	 *
	 * @param bool   $expected
	 * @param string $file
	 */
	public function testFileExists(bool $expected, string $file){
		$this->assertSame($expected,  $this->filereader->fileExists($file));
	}

	/**
	 * @dataProvider fileDataProvider
	 *
	 * @param bool   $expected
	 * @param string $file
	 */
	public function testIsFile(bool $expected, string $file){
		$this->assertSame($expected,  $this->filereader->isFile($file));
	}

	/**
	 * @dataProvider dirDataProvider
	 *
	 * @param bool   $expected
	 * @param string $dir
	 */
	public function testIsDir(bool $expected, string $dir){
		$this->assertSame($expected, $this->filereader->isDir($dir));
	}

	/**
	 * @dataProvider fileContentDataProvider
	 *
	 * @param string $expected
	 * @param string $file
	 */
	public function testFileContents(string $expected, string $file){
		$this->assertSame($expected, $this->filereader->fileContents($file));
	}

	public function testFileContentsNotFoundException(){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('File not found: foo.bar');

		$this->filereader->fileContents('foo.bar');
	}

	/**
	 * @dataProvider fileRequireDataProvider
	 *
	 * @param        $expected
	 * @param string $file
	 */
	public function testGetRequire($expected, string $file){
		$this->assertSame($expected, $this->filereader->getRequire($file));
	}

	public function testGetRequireNotFoundException(){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('File not found: foo.bar');

		$this->filereader->getRequire('foo.bar');
	}

	/**
	 * @dataProvider makeDirDataProvider
	 *
	 * @param string $dir
	 */
	public function testMakeDir(string $dir){
		$this->assertTrue($this->filereader->makeDir($dir));
	}

	public function testMakeDirExistsException(){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('Directory already exists:');

		$this->filereader->makeDir($this->test_dir);
	}

	/**
	 * @dataProvider fileCopyDataProvider
	 *
	 * @param string $src
	 * @param string $dest
	 */
	public function testCopyFile(string $src, string $dest){
		$this->assertTrue($this->filereader->copyFile($src, $dest));
	}

	/**
	 * @dataProvider             fileCopyDataProvider
	 *
	 * @param string $src
	 * @param string $dest
	 */
	public function testCopyFileExistsException(string $src, string $dest){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('Destination file already exists.');

		$this->filereader->copyFile($src, $dest, false);
	}

	/**
	 * @dataProvider renameFileDataProvider
	 *
	 * @param string $oldname
	 * @param string $newname
	 */
	public function testRename(string $oldname, string $newname){
		$this->assertTrue($this->filereader->rename($oldname, $newname));
	}

	/**
	 * @dataProvider renameFileExceptionDataProvider
	 *
	 * @param string $oldname
	 * @param string $newname
	 */
	public function testRenameExistsException(string $oldname, string $newname){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('Destination already exists.');

		$this->assertTrue($this->filereader->rename($oldname, $newname, false));
	}

	/**
	 * @dataProvider deleteFileDataProvider
	 *
	 * @param string $file
	 */
	public function testDeleteFile(string $file){
		$this->assertTrue($this->filereader->deleteFile($file));
	}

	/**
	 * @dataProvider deleteFileDataProvider
	 *
	 * @param string $file
	 */
	public function testDeleteFileNotFoundException(string $file){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('File not found:');

		$this->filereader->deleteFile($file);
	}

	/**
	 * @dataProvider makeDirDataProvider
	 *
	 * @param string $dir
	 */
	public function testDeleteDir(string $dir){
		$this->assertTrue($this->filereader->deleteDir($dir));
	}

	/**
	 * @dataProvider makeDirDataProvider
	 *
	 * @param string $dir
	 */
	public function testDeleteDirNotFoundException($dir){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('Directory not found:');

		$this->filereader->deleteDir($dir);
	}

	/**
	 * @dataProvider writeDataProvider
	 *
	 * @param string $filepath
	 * @param string $data
	 */
	public function testWrite(string $filepath, string $data){
		$expectedBytes = strlen($data);
		$bytesWritten  = $this->filereader->write($filepath, $data);

		$this->assertSame($expectedBytes, $bytesWritten);
	}

	/**
	 * @dataProvider writeDataProvider
	 *
	 * @param string $filepath
	 * @param string $data
	 */
	public function testWriteFileExistsException(string $filepath, string $data){
		$this->expectException(FilereaderException::class);
		$this->expectExceptionMessage('Destination file already exists.');

		$this->filereader->write($filepath, $data, false);
	}

}
