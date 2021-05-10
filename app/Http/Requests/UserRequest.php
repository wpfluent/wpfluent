<?php

namespace WPFluentApp\Http\Requests;

use WPFluentFramework\Foundation\RequestGuard;

class UserRequest extends RequestGuard
{
    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }
}
