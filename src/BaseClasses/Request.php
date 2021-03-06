<?php

namespace Inpin\Foundation\BaseClasses;

use Illuminate\Foundation\Http\FormRequest;
use Inpin\Foundation\Utils\Helper;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param string $prefix
     * @return array
     */
    public function rules($prefix = '')
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
                return Helper::appendParentToArrayKeys($this->postRules($prefix), $prefix);
            case 'PUT':
            case 'PATCH':
                return Helper::appendParentToArrayKeys($this->putRules($prefix), $prefix);
        }
    }

    /**
     * Get the validation rules that apply to the post request.
     *
     * @param string $prefix
     * @return array
     */
    protected abstract function postRules($prefix = '');

    /**
     * Get the validation rules that apply to the put/patch request.
     *
     * @param string $prefix
     * @return array
     */
    protected function putRules($prefix = '')
    {
        return $this->postRules($prefix);
    }
}
