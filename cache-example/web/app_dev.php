<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../app/AppKernel.php';

try {
	$kernel = new AppKernel('dev', true);
	$request = Request::createFromGlobals();
	$response = $kernel->handle($request);
	$response->send();
	$kernel->terminate($request, $response);
} catch (Throwable $t) {
	print_r($t->getMessage());
	die();
}
