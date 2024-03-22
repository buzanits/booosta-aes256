<?php
namespace booosta\aes256;
use \booosta\Framework as b;
b::init_module('aes256');

class aes256 extends \booosta\crypter\Crypter
{
  use moduletrait_aes256;

  protected $key, $iv = '';
  protected $cipher = 'aes-256-cbc';

  public function __construct($key = null)
  {
    parent::__construct();

    if($this->key === false) return false;
    $this->check_install(false);

    if($key !== null) $this->key = $key;
    #elseif(!is_readable($this->config('aes256_keyfile'))) $this->key = false;
    #else include($this->config('aes256_keyfile'));
  }

  public function set_key($data) { $this->key = $data; }
  public function set_iv($data) { $this->iv = $data; }
  public function set_cipher($data) { $this->cipher = $data; }

  public function encrypt($plaintext)
  {
    if($this->retrieve_key() === null) return false;
    if(!$this->check_install()) return null;
 
    return base64_encode(openssl_encrypt($plaintext, $this->cipher, base64_decode($this->retrieve_key()), 0, $this->iv));
  }

  public function decrypt($ciphertext)
  {
    if($this->retrieve_key() === null) return false;
    if(!$this->check_install()) return null;
 
    return openssl_decrypt(base64_decode($ciphertext), $this->cipher, base64_decode($this->retrieve_key()), 0, $this->iv);
  }

  protected function retrieve_key()
  {
    if($this->key) return $this->key;
    if(is_readable($this->config('aes256_keyfile'))) include($this->config('aes256_keyfile'));
    return $key;
  }

  protected function check_install($check_cipher = true)
  {
    if(!is_callable('openssl_decrypt')):
      $this->error('openssl_decrypt not available');
      return false;
    endif;

    if($check_cipher && !in_array($this->cipher, openssl_get_cipher_methods())):
      $this->error("Cipher method $this->cipher not available");
      return false;
    endif;

    return true;
  }
}
