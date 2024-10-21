<?php

require_once __DIR__ . '/autoload.php';

use core\App;

$app = new App();




$app->router->get('/', ['HomeController', 'index']);
$app->router->get('/about', ['AboutController', 'index']);

// Auth
$app->router->get('/signup', ['AuthController', 'viewRegister']);
$app->router->post('/signup', ['AuthController', 'register']);
$app->router->get('/login', ['AuthController', 'viewLogin']);
$app->router->post('/login', ['AuthController', 'login']);
$app->router->get('/signout', ['AuthController', 'signout']);

$app->router->get('/home', ['HomeController', 'getLowongan']);

// Job
$app->router->get('/company/createjob', ['JobController', 'viewCreateJob'], ['CompanyMiddleware']);
$app->router->post('/company/createjob', ['JobController', 'createJob'], ['CompanyMiddleware']);
$app->router->get('/company/job/:id/editjob', ['JobController', 'viewEditJob']);
$app->router->post('/company/job/:id/editjob', ['JobController', 'editJob']);
$app->router->get('/company/job/:id', ['JobController', 'viewJobDetail'], ['CompanyMiddleware']);

$app->router->get('/company', ['HomeController','indexCompany']);
$app->router->get('/home/company', ['HomeController', 'getLowonganCompany']);
$app->router->delete('/company/job', ['JobController', 'deleteLowonganCompany']);
$app->router->patch('/company/job/changeopen', ['JobController', 'changeopenlowongan']);

// Lamaran
$app->router->get('/lamaran/riwayat', ['LamaranController', 'viewHistory']);
$app->router->get('/lamaran/datariwayat', ['LamaranController', 'getLamaran']);
$app->router->get('/lamaran/:id', ['LamaranController', 'viewCreateLamaran']);
$app->router->post('/lamaran/:id', ['LamaranController', 'createLamaran']);


// Lamaran Company
$app->router->get('/company/lamaran/:id',
['LamaranController', 'viewLamaranCompany'], ['CompanyMiddleware']  
);
$app->router->post('/company/lamaran/:id/status',
['LamaranController', 'changeLamaranStatus'], ['CompanyMiddleware']  
);
$app->router->get('/company/job/:id/download',
['LamaranController', 'exportLamaranCSV'] , ['CompanyMiddleware']
);


// Company Profile
$app->router->get('/profile', ['CompanyProfileController', 'viewCompanyProfile'], ['CompanyMiddleware']);
$app->router->get('/profile/edit', ['CompanyProfileController', 'viewCompanyProfileEdit'], ['CompanyMiddleware']);
$app->router->post('/profile/edit', ['CompanyProfileController', 'editCompanyProfile'], ['CompanyMiddleware']);

// 404
$app->router->get('/notfound', ['HomeController', 'viewError']);

// Lowongan
$app->router->get('/detail-lowongan/:id', ['LowonganController', 'getDetailLowongan']);
$app->run();



