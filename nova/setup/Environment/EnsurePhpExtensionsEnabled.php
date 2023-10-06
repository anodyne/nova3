<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpExtensionsEnabled
{
    public function handle(array $content, Closure $next)
    {
        $content['items']['extensions']['header'] = 'PHP extensions';

        $extensions = [
            ['key' => 'ctype', 'name' => 'Ctype', 'description' => 'The functions provided by this extension check whether a character or string falls into a certain character class according to the current locale', 'enabled' => true],
            ['key' => 'curl', 'name' => 'cURL', 'description' => 'cURL allows you to connect and communicate to many different types of servers with many different types of protocols (http, https, ftp, gopher, telnet, dict, file, and ldap)', 'enabled' => true],
            ['key' => 'dom', 'name' => 'DOM', 'description' => 'The DOM extension allows operations on XML and HTML documents through the DOM API with PHP', 'enabled' => true],
            ['key' => 'fileinfo', 'name' => 'Fileinfo', 'description' => 'The functions in this module try to guess the content type and encoding of a file by looking for certain magic byte sequences at specific positions within the file', 'enabled' => true],
            ['key' => 'filter', 'name' => 'Filter', 'description' => 'This extension filters data by either validating or sanitizing it. This is especially useful when the data source contains unknown (or foreign) data, like user supplied input.', 'enabled' => true],
            ['key' => 'hash', 'name' => 'Hash', 'description' => 'Message Digest (hash) engine. Allows direct or incremental processing of arbitrary length messages using a variety of hashing algorithms.', 'enabled' => true],
            ['key' => 'mbstring', 'name' => 'Multibyte String', 'description' => 'Multibyte string provides multibyte specific string functions that help you deal with multibyte encodings in PHP', 'enabled' => true],
            ['key' => 'openssl', 'name' => 'OpenSSL', 'description' => 'This extension binds functions of » OpenSSL library for symmetric and asymmetric encryption and decryption, PBKDF2, PKCS7, PKCS12, X509 and other crypto operations. In addition to that it provides implementation of TLS streams.', 'enabled' => true],
            ['key' => 'pcre', 'name' => 'PCRE', 'description' => 'The PCRE library is a set of functions that implement regular expression pattern matching using the same syntax and semantics as Perl 5', 'enabled' => true],
            ['key' => 'pdo', 'name' => 'PDO', 'description' => 'The PHP Data Objects (PDO) extension defines a lightweight, consistent interface for accessing databases in PHP', 'enabled' => true],
            ['key' => 'session', 'name' => 'Sessions', 'description' => 'Session support in PHP consists of a way to preserve certain data across subsequent accesses', 'enabled' => true],
            ['key' => 'tokenizer', 'name' => 'Tokenizer', 'description' => 'The tokenizer functions provide an interface to the PHP tokenizer embedded in the Zend Engine. Using these functions you may write your own PHP source analyzing or modification tools without having to deal with the language specification at the lexical level.', 'enabled' => true],
            ['key' => 'xml', 'name' => 'XML', 'description' => 'This extension lets you create XML parsers and then define handlers for different XML events', 'enabled' => true],
        ];

        $missingExtensions = collect();

        foreach ($extensions as $index => $extension) {
            if ($extension['key'] === 'xml') {
                $extensions[$index]['enabled'] = false;
            } else {
                if (! extension_loaded($extension['key'])) {
                    $extensions[$index]['enabled'] = false;
                }
            }
        }

        $content['items']['extensions'] = $extensions;

        $content['errors'] = collect($extensions)->filter(fn ($item) => $item['enabled'] === false)->count();

        if ($content['errors'] > 0) {
            $content['items']['extensions']['fail'] = sprintf(
                'The version of PHP your server is running is missing %d %s. Please contact your web host for assistance with fixing this issue.',
                $content['errors'],
                str('extension')->plural($content['errors'])
            );
        }

        // if ($missingExtensions->count() > 0) {
        //     $content['errors'] += 1;

        //     $content['items']['extensions']['fail'] = sprintf(
        //         'The version of PHP your server is running is missing the %s %s. Please contact your web host to ensure %s enabled for your site.',
        //         $missingExtensions->join(', ', ' and '),
        //         str('extension')->plural($missingExtensions->count()),
        //         trans_choice('this extension is|these extensions are', $missingExtensions->count())
        //     );
        // }

        return $next($content);
    }
}
