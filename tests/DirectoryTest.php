<?php
/**
 * Class DirectoryTest
 *
 * @filesource   DirectoryTest.php
 * @created      05.03.2017
 * @package      chillerlan\FilereaderTest
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\FilereaderTest;

use chillerlan\Filereader\Directory;
use chillerlan\Filereader\Drivers\DiskDriver;
use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase{

	const TEST_DIR = __DIR__.DIRECTORY_SEPARATOR.'test';

	/**
	 * @var \chillerlan\Filereader\Directory
	 */
	protected $directory;

	protected function setUp(){
		$this->directory = new Directory(new DiskDriver, self::TEST_DIR);
	}

	public function testRead(){
		/** @var \chillerlan\Filereader\File $file */
		foreach($this->directory->read() as $file){
			$this->assertSame(self::TEST_DIR, $file->directory->path);
			$this->assertTrue(in_array($file->name, ['testfile.txt', 'testscript.php']));
		}
	}

	/**
	 * @expectedException \chillerlan\Filereader\FilereaderException
	 * @expectedExceptionMessage Directory not found: foo
	 */
	public function testReadNotFoundException(){
		(new Directory(new DiskDriver, 'foo'))->read();
	}

	public function testCreate(){
		$this->assertTrue($this->directory->create('foobar'));
		$this->directory->change(self::TEST_DIR.DIRECTORY_SEPARATOR.'whatever');
		$this->assertTrue($this->directory->create());
	}

	public function testDelete(){
		$this->assertTrue($this->directory->delete('foobar'));
		$this->directory->change(self::TEST_DIR.DIRECTORY_SEPARATOR.'whatever');
		$this->assertTrue($this->directory->delete());
	}

	public function testRename(){
		$this->directory->change(self::TEST_DIR.DIRECTORY_SEPARATOR.'foobar')->create();

		$new_path = self::TEST_DIR.DIRECTORY_SEPARATOR.'whatever';

		$this->assertSame($new_path, $this->directory->rename($new_path)->path);
		$this->directory->delete();
	}
}
