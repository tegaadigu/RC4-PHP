<?php
/**
 * Created by PhpStorm.
 * User: tegaadigu
 * Date: 03/06/2018
 * Time: 12:05 PM
 */

namespace tests;

use App\RC4;
use PHPUnit\Framework\TestCase;

class RC4Test extends TestCase
{

  /**
   * Initial setup of test declare new RC4 Object.
   */
  public function setUp()
  {
    $this->rc4 = new RC4();
  }

  /**
   * @test
   * @expectedException \OutOfRangeException
   * @expectedExceptionCode 40
   * @expectedExceptionMessage key must be between 1 and 256 bytes
   */
  public function shouldThrowExceptionForInvalidKeyLength(): void
  {
    $this->rc4->setKey('');
  }

  /**
   * @test
   * @dataProvider provideShouldEncryptPlainText
   *
   * @param string $plainText
   * @param string $key
   * @param string $expected
   */
  public function shouldEncryptPlainText(string $plainText, string $key, string $expected) : void
  {
    $this->rc4->setKey($key);
    $result = $this->rc4->encrypt($plainText, true);
    $this->assertEquals($result, $expected);
  }

  /**
   * @return array
   */
  public function provideShouldEncryptPlainText() : array
  {
    return [
      [
        'plainText' => 'tester',
        'key' => 'test',
        'expected' => '4a9b715d707e'
      ]
    ];
  }


  /**
   * @test
   * @dataProvider provideShouldDecryptCipher
   *
   * @param string $cipherText
   * @param string $key
   * @param string $expected
   */
  public function shouldDecryptCipher(string $cipherText,string $key, string $expected) : void
  {
    $this->rc4->setKey($key);
    $this->assertEquals($this->rc4->decrypt($cipherText, true), $expected);
  }

  /**
   * @return array
   */
  public function provideShouldDecryptCipher() : array
  {
    return [
      [
        'cipherText' => '4a9b715d707e',
        'key' => 'test',
        'expected' => 'tester'
      ]
    ];
  }
}
