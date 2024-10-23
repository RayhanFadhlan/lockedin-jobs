<?php

require_once __DIR__ . '/autoload.php';

use core\App;

$app = new App();




$app->router->get('/', ['HomeController', 'index']);

// Auth
$app->router->get('/signup', ['AuthController', 'viewRegister']);
$app->router->post('/signup', ['AuthController', 'register']);
$app->router->get('/login', ['AuthController', 'viewLogin']);
$app->router->post('/login', ['AuthController', 'login']);
$app->router->get('/signout', ['AuthController', 'signout']);

$app->router->get('/home', ['HomeController', 'getLowongan']);

// Job Company
$app->router->get('/company/createjob', ['JobController', 'viewCreateJob'], ['CompanyMiddleware']);
$app->router->post('/company/createjob', ['JobController', 'createJob'], ['CompanyMiddleware']);
$app->router->get('/company/job/:id/editjob', ['JobController', 'viewEditJob'], ['CompanyMiddleware']);
$app->router->post('/company/job/:id/editjob', ['JobController', 'editJob'], ['CompanyMiddleware']);
$app->router->get('/company/job/:id', ['JobController', 'viewJobDetail'], ['CompanyMiddleware']);

$app->router->get('/company', ['HomeController','indexCompany'], ['CompanyMiddleware']);
$app->router->get('/home/company', ['HomeController', 'getLowonganCompany'], ['CompanyMiddleware']);
$app->router->delete('/company/job', ['JobController', 'deleteLowonganCompany'], ['CompanyMiddleware']);
$app->router->patch('/company/job/changeopen', ['JobController', 'changeopenlowongan'], ['CompanyMiddleware']);

// Lamaran
$app->router->get('/lamaran/riwayat', ['LamaranController', 'viewHistory'], ['JobSeekerMiddleware']);
$app->router->get('/lamaran/datariwayat', ['LamaranController', 'getLamaran'], ['JobSeekerMiddleware']);
$app->router->get('/lamaran/:lowonganId', ['LamaranController', 'viewCreateLamaran'], ['JobSeekerMiddleware']);
$app->router->post('/lamaran/:lowonganId', ['LamaranController', 'createLamaran'], ['JobSeekerMiddleware']);


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

// Lowongan Jobseeker
$app->router->get('/lowongan/:id', ['LowonganController', 'getDetailLowongan']);

// Storage Files For Private files
$app->router->get('/storage/videos/:name', ['StorageController', 'servePrivate']);
$app->router->get('/storage/cv/:name', ['StorageController', 'servePrivate']);


$app->run();



