<?php
/**
 * Created by PhpStorm.
 * User: tegaadigu
 * Date: 03/06/2018
 * Time: 12:10 PM
 */

namespace App;

/**
 * Class RC4
 * @package App
 */
class RC4
{
  /**
   * @var string
   */
  private $key;

  /**
   * @var int
   */
  private $maxLength;

  /**
   * RC4 constructor.
   */
  public function __construct()
  {
    $this->key = '';
    $this->maxLength = 256;
  }

  /**
   * @param string $key
   *
   * @throws \OutOfRangeException
   */
  public function setKey(string $key) : void
  {
    $length = \strlen($key);
    if ($length < 1 || $length > 256) {
      throw new \OutOfRangeException('key must be between 1 and 256 bytes', 40);
    }
    $this->key = $key;
  }

  /**
   * @param string $plainText
   *
   * @param bool $convertToHex
   *
   * @return string
   */
  public function encrypt(string $plainText, $convertToHex = false) : string
  {
    //convert result to readable string to avoid phpunit encoding issues.
    return $convertToHex ? bin2hex($this->process($plainText)) : $this->process($plainText);
  }

  /**
   * @param string $encryptedText
   *
   * @param bool $convertToBin
   *
   * @return string
   */
  public function decrypt(string $encryptedText, $convertToBin = false) : string
  {
      return $this->process($convertToBin ? hex2bin($encryptedText) : $encryptedText);
  }

  /**
   * @param string $string
   *
   * @return string
   */
  private function process(string $string) : string
  {
    $stringPermutation = $this->performKeyScheduling(range(0, $this->maxLength - 1));
    return $this->generationAlgorithm($stringPermutation, $string);
  }

  /**
   * @param array $keyArray
   *
   * @return array
   */
  private function performKeyScheduling(array $keyArray) : array
  {
    $j = 0;
    for ($i = 0; $i < $this->maxLength; $i++) {
      $j = ($j + $keyArray[$i] + \ord($this->key[$i % \strlen($this->key)])) % 256;
        $this->swap($keyArray, $keyArray[$i], $keyArray[$j]);
    }
    return $keyArray;
  }

  /**
   * Pseudo-random generation algorithm (PRGA)
   * @param array $stringPermutation
   * @param string $string
   *
   * @return string
   */
  private function generationAlgorithm(array $stringPermutation, string $string) : string
  {
    $stringLength = \strlen($string);
    $i = 0;
    $j = 0;
    $res = '';
    for ($y = 0; $y < $stringLength; $y++) {
      $i = ($i + 1) % 256;
      $j = ($j + $stringPermutation[$i]) % 256;
      $this->swap($stringPermutation, $stringPermutation[$i], $stringPermutation[$j]);
      $res .= $string[$y] ^ \chr($stringPermutation[($stringPermutation[$i] + $stringPermutation[$j]) % 256]);
    }
    return $res;
  }

  /**
   * @param $array
   * @param $indexA
   * @param $indexB
   */
  private function swap(&$array,$indexA,$indexB) : void {
    [$array[$indexA], $array[$indexB]] = [$array[$indexB], $array[$indexA]];
  }
}
