<?php

namespace Inpin\Foundation\Utils;


class PolicyHelper
{
    /**
     * Authorize a given action for the current user.
     *
     * @param  mixed $ability
     * @param  mixed|array $arguments
     */
    public static function authorizeApi($ability, $arguments = [])
    {
        if (!request()->user('api')->can($ability, $arguments)) {
            abort(HttpResponse::FORBIDDEN, 'This action is unauthorized.');
        }
    }
}
