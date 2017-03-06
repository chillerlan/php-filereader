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
	 * @param        $expected
	 * @param string $file
	 */
	public function testFileContents($expected, string $file){
		$this->assertSame($expected, $this->filereader->fileContents($file));
	}

	/**
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage File not found: foo.bar
	 */
	public function testFileContentsNotFoundException(){
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

	/**
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage File not found: foo.bar
	 */
	public function testGetRequireNotFoundException(){
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

	/**
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage Directory already exists:
	 */
	public function testMakeDirExistsException(){
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
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage Destination file already exists.
	 *
	 * @param string $src
	 * @param string $dest
	 */
	public function testCopyFileExistsException(string $src, string $dest){
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
	 *
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage Destination already exists.
	 */
	public function testRenameExistsException(string $oldname, string $newname){
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
	 *
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage File not found:
	 */
	public function testDeleteFileNotFoundException(string $file){
		$this->filereader->deleteFile($file);
	}

	/**
	 * @dataProvider makeDirDataProvider
	 *
	 * @param string $dir
	 */
	public function testDeleteDir($dir){
		$this->assertTrue($this->filereader->deleteDir($dir));
	}

	/**
	 * @dataProvider makeDirDataProvider
	 *
	 * @param string $dir
	 *
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage Directory not found:
	 */
	public function testDeleteDirNotFoundException($dir){
		$this->filereader->deleteDir($dir);
	}

}
