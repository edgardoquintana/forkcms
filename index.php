<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

// vendors not installed
if(!is_dir(__DIR__ . '/vendor'))
{
	echo 'Your install is missing some dependencies. If you have composer installed you should run: <code>composer install</code>. If you don\'t have composer installed you really should, see http://getcomposer.org for more information';
	exit;
}

require_once __DIR__ . '/autoload.php';

use Symfony\Component\HttpFoundation\Request;

// Fork has not yet been installed
$installer = dirname(__FILE__) . '/install/cache';
$request = Request::createFromGlobals();
if(
	file_exists($installer) &&
	is_dir($installer) &&
	!file_exists($installer . '/installed.txt') &&
	substr($request->getRequestURI(), 0, 8) != '/install'
)
{
	header('Location: /install');
	exit;
}

require_once __DIR__ . '/app/AppKernel.php';

$kernel = new AppKernel();
$response = $kernel->handle($request);
$response->send();
