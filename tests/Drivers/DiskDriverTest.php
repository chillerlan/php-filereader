<?php
/**
 * Class DiskDriverTest
 *
 * @filesource   DiskDriverTest.php
 * @created      04.03.2017
 * @package      chillerlan\FilereaderTest\Drivers
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\FilereaderTest\Drivers;

use chillerlan\Filereader\Drivers\DiskDriver;

class DiskDriverTest extends DriverTestAbstract{

	protected $test_dir = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'test';

	protected function setUp(){
		$this->filereader = new DiskDriver;
	}

	public function fileDataProvider(){
		return [
			[true,  $this->test_dir.DIRECTORY_SEPARATOR.'testfile.txt'],
			[false, 'foo.txt'],
		];
	}

	public function dirDataProvider(){
		return [
			[true,  $this->test_dir],
			[false, 'foo'],
		];
	}

	public function fileContentDataProvider(){
		return [
			['foo',  $this->test_dir.DIRECTORY_SEPARATOR.'testfile.txt'],
		];
	}

	public function fileRequireDataProvider(){
		return [
			[['foo' => 'bar'],  $this->test_dir.DIRECTORY_SEPARATOR.'testscript.php'],
		];
	}

	public function fileCopyDataProvider(){
		return [
			[$this->test_dir.DIRECTORY_SEPARATOR.'testfile.txt',  $this->test_dir.DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'testfilecopy.txt'],
		];
	}

	public function makeDirDataProvider(){
		return [
			[$this->test_dir.DIRECTORY_SEPARATOR.'foo'],
		];
	}

	public function deleteFileDataProvider(){
		return [
			[$this->test_dir.DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'testfile.txt'],
		];
	}

	public function renameFileDataProvider(){
		return [
			[$this->test_dir.DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'testfilecopy.txt', $this->test_dir.DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'testfile.txt'],
		];
	}

	public function renameFileExceptionDataProvider(){
		return [
			[$this->test_dir.DIRECTORY_SEPARATOR.'foo'.DIRECTORY_SEPARATOR.'testfile.txt', $this->test_dir.DIRECTORY_SEPARATOR.'testfile.txt'],
		];
	}

}
