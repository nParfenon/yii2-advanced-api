<?php

namespace api\modules\v1\controllers;

use api\controllers\BaseApiController;
use common\models\User;

class UserController extends BaseApiController
{

    public $modelClass = User::class;



}
