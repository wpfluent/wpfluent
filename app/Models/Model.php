<?php

namespace WPFluentApp\Models;

use WPFluentFramework\Database\Orm\Model as BaseModel;

class Model extends BaseModel
{
    protected $guarded = ['id', 'ID'];
}