<?php
namespace controllers;

use models\UserModel;

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }
}
?>
