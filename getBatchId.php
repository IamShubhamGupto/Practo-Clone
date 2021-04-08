<?php

$client = new http\Client;
$request = new http\Client\Request;

$body = new http\Message\Body;
$body->append('{}');

$request->setRequestUrl('https://api.sendgrid.com/v3/mail/batch');
$request->setRequestMethod('POST');
$request->setBody($body);

$request->setHeaders(array(
  'authorization' => 'Bearer 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'
));

$client->enqueue($request)->send();
$response = $client->getResponse();

echo $response->getBody();