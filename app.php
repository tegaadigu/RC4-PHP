<?php
/**
 * Created by PhpStorm.
 * User: tegaadigu
 * Date: 03/06/2018
 * Time: 12:40 PM
 */

include __DIR__ . '/vendor/autoload.php';

use App\RC4;

$rc4 = new RC4();

function enterCipherKey(RC4 $rc4, bool $decrypt = false) : void {
  echo "Enter cipher key (make sure key length > 0 < 255)\n key:";
  $rc4->setKey(readStream());
  echo 'Enter string you\'d like to ', ($decrypt ? 'decrypt' : 'encrypt'), PHP_EOL, 'string:';
  $result = $decrypt ? $rc4->decrypt(readStream(), true) : $rc4->encrypt(readStream(), true);
  echo 'Your ', ($decrypt ? 'decrypted' : 'encrypted'), 'string is : ', $result.PHP_EOL;
}

/**
 * @return string
 */
function readStream() : string {
  $handle = fopen ('php://stdin', 'rb');
  return trim(fgets($handle));
}

/**
 *
 */
function endProgram() : void {
  echo 'Thank you for trying out RC4 Program:' . PHP_EOL;
  exit;
}

$line = '';
do{
  echo "Welcome to RC4 Cipher program\n\nChoose From the below Option\n\n 1: Encrypt \n 2: Decrypt \n 3: exit/quit \n\n option:";
  $line = readStream();
  if(in_array($line, ['exit', '3', 'quit'], true)){
    endProgram();
  }
  switch ($line) {
    case '1':
      enterCipherKey($rc4);
      break;
    case '2':
      enterCipherKey($rc4, true);
      break;
    default:
      exit();
  }
}while($line = 'yes');
echo "\n";
echo "Thank you, continuing...\n";

