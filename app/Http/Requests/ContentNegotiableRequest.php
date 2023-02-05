<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ContentNegotiableRequest extends FormRequest {

    /**
     * 
     * The reason for this work around, has to do with the fact these custom request were meant to be stateful. 
     * If  you look in \Illuminate\Foundation\Http\FormRequest@failedValidation, heres what you see
     *  
     * throw (new ValidationException($validator))
     *              ->errorBag($this->errorBag)
     *               ->redirectTo($this->getRedirectUrl());
     * 
     * There is no way to change this behavior with configuration, but I like how the request objects off validation de-coupling. 
     * So I usually write a small class like this that I can extend all my custom requets from
     * 
     * @param Validator $validator
     * @return array
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // For API or ajax requets, reward those who send media type headers
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
        
        
    }

    /**
     * We will be handling API auth in a different way
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    abstract public function rules();
}