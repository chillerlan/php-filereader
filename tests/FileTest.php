<?php
/**
 * Class FileTest
 *
 * @filesource   FileTest.php
 * @created      06.03.2017
 * @package      chillerlan\FilereaderTest
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\FilereaderTest;

use chillerlan\Filereader\Directory;
use chillerlan\Filereader\Drivers\DiskDriver;
use chillerlan\Filereader\File;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase{

	const TEST_DIR = __DIR__.DIRECTORY_SEPARATOR.'test';

	/**
	 * @var \chillerlan\Filereader\Directory
	 */
	protected $directory;

	/**
	 * @var \chillerlan\Filereader\File
	 */
	protected $file;

	/**
	 * @var \chillerlan\Filereader\Drivers\FSDriverInterface
	 */
	protected $filereader;

	protected function setUp():void{
		$this->filereader = new DiskDriver;
		$this->directory  = new Directory($this->filereader, self::TEST_DIR);
		$this->file       = new File($this->filereader, $this->directory, 'testscript.php');
	}

	public function testInfo(){
		$info = $this->file->info();

		$this->assertSame(self::TEST_DIR, $info['dirname']);
		$this->assertSame('testscript.php', $info['basename']);
		$this->assertSame('php', $info['extension']);
		$this->assertSame('testscript', $info['filename']);
	}

	public function testExists(){
		$this->assertTrue($this->file->exists());
	}

	public function testContent(){
		$expected = '<?php return [\'foo\' => \'bar\'];'.PHP_EOL;

		$this->assertSame($expected, $this->file->content());
	}

	public function testGetRequire(){
		$this->assertSame(['foo' => 'bar'], $this->file->getRequire());
	}

	public function testCopy(){
		$this->assertTrue($this->file->copy($this->file->directory->path.DIRECTORY_SEPARATOR.'testcopy.php'));
	}

	public function testRename(){
		$this->file = new File($this->filereader, $this->directory, 'testcopy.php');

		$this->file->rename($this->file->directory->path.DIRECTORY_SEPARATOR.'.testcopy');

		$this->assertSame('.testcopy', $this->file->name);
		$this->assertSame(self::TEST_DIR, $this->file->directory->path);
	}

	public function testDelete(){
		$this->file = new File($this->filereader, $this->directory, '.testcopy');

		$this->assertTrue($this->file->delete());
	}

}
