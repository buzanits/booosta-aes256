# Booosta AES256 module - Tutorial

## Abstract

This tutorial covers the aes256 module of the Booosta PHP framework. If you are new to this framework, we strongly
recommend, that you first read the [general tutorial of Booosta](https://github.com/buzanits/booosta-installer/blob/master/tutorial/tutorial.md).

## Purpose

The purpose of this module is to provide AES-256 encryption. There are methods for encrypting and decrypting data with AES-256.

## Installation

This module can be loaded with

```
composer require booosta/aes256
```

This also loads eventual addtional dependent modules.

## Requirements

PHP must be compiled with openssl support. If you get the error `openssl_decrypt not available` then this is probably not the case.

## Usage

```
# tl;dr
# instantiate crypter object
$crypter = $this->makeInstance('aes256', $my_secret_key);

# encrypt data
$cyphertext = $crypter->encrypt('Secret Message');

# decrypt data
$plaintext = $crypter->decrypt($cyphertext);
```

Instead of providing the key in the constructor, you can put it into a file and provide the file path in the `local/config.inc.php`.

```
# /etc/booosta.key
<?php $this->key = '12345678901234567890123456789012'; ?>

# local/config.incl.php
# [...]
  'aes256_keyfile' => '/etc/booosta.key',
# [...]

# test.php
$crypter = $this->makeInstance('aes256');

# You also can change the key after instanciation
$crypter->set_key($my_secret_key);
```

You also can change the IV and the cipher algorithm of AES-256. Please see the [PHP manual](https://www.php.net/manual/en/function.openssl-encrypt.php) for details on this. Per default the IV ist empty and `aes-256-cbc` is used as cipher algorithm.

```
$crypter->set_iv($my_iv);
$crypter->set_cipher($my_cipher_algorithm);
```
