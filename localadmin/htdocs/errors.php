<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 31.01.2016
 * Time: 19:04
 */


if (!empty($_SERVER['REDIRECT_STATUS'])) {
    $status = $_SERVER['REDIRECT_STATUS'];
} else {
    $status = 404;
}
$codes = array(
    400 => array('Bad Request', 'The request cannot be fulfilled due to bad syntax.'),
    403 => array('Forbidden', 'The server has refused to fulfil your request.'),
    404 => array('Not Found', 'The page you requested was not found on this server.'),
    405 => array('Method Not Allowed', 'The method specified in the request is not allowed for the specified resource.'),
    408 => array('Request Timeout', 'Your browser failed to send a request in the time allowed by the server.'),
    500 => array('Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.'),
    502 => array('Bad Gateway', 'The server received an invalid response while trying to carry out the request.'),
    504 => array('Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.'),
);

echo "<html lang='en'>
<head>
    <meta charset='utf-8'>
   <title>" . $codes[$status][0] . " - " . $status . " error</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='assets/css/bootstrap.css' rel='stylesheet'>
<link rel='apple-touch-icon' sizes='57x57' href='favicons/apple-touch-icon-57x57.png'>
<link rel='apple-touch-icon' sizes='60x60' href='favicons/apple-touch-icon-60x60.png'>
<link rel='apple-touch-icon' sizes='72x72' href='favicons/apple-touch-icon-72x72.png'>
<link rel='apple-touch-icon' sizes='76x76' href='favicons/apple-touch-icon-76x76.png'>
<link rel='apple-touch-icon' sizes='114x114' href='favicons/apple-touch-icon-114x114.png'>
<link rel='apple-touch-icon' sizes='120x120' href='favicons/apple-touch-icon-120x120.png'>
<link rel='apple-touch-icon' sizes='144x144' href='favicons/apple-touch-icon-144x144.png'>
<link rel='apple-touch-icon' sizes='152x152' href='favicons/apple-touch-icon-152x152.png'>
<link rel='apple-touch-icon' sizes='180x180' href='favicons/apple-touch-icon-180x180.png'>
<link rel='icon' type='image/png' href='favicons/favicon-32x32.png' sizes='32x32'>
<link rel='icon' type='image/png' href='favicons/android-chrome-192x192.png' sizes='192x192'>
<link rel='icon' type='image/png' href='favicons/favicon-96x96.png' sizes='96x96'>
<link rel='icon' type='image/png' href='favicons/favicon-16x16.png' sizes='16x16'>
<link rel='manifest' href='favicons/manifest.json'>
<link rel='mask-icon' href='favicons/safari-pinned-tab.svg' color='#3c6fb1'>
<link rel='shortcut icon' href='favicons/favicon.ico'>
<meta name='apple-mobile-web-app-title' content='Control'>
<meta name='application-name' content='Control'>
<meta name='msapplication-TileColor' content='#ffffff'>
<meta name='msapplication-TileImage' content='favicons/mstile-144x144.png'>
<meta name='msapplication-config' content='favicons/browserconfig.xml'>
<meta name='theme-color' content='#ffffff'>
<style>.panel{margin-top: 33%;} .btn{margin-top: 50px;margin-left: 45%;
margin-bottom: 20px;}</style>
</head>
<body>
<div class='container'>
 <div class='row'>
    <div class='col-md-2'></div>
    <div class='col-md-8'>
      <div class='panel panel-danger'>
        <div class='panel-heading'>
          <h1 class='text-center'>
          " . $codes[$status][0] . " - <b>" . $status . " error</b>
          </h1>
          <p class='text-center'>" . $codes[$status][1] . "</p>
          <a class='btn btn-default btn-primary' href='/' role='button'>Home</a>
        </div>
      </div>
    </div>
</div>
</body>
<html>";
?>