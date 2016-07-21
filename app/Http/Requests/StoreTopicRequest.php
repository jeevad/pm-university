<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Topic;
use Illuminate\Contracts\Validation\Validator;

class StoreTopicRequest extends Request
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
     * @return array
     */
    public function rules()
    {
        return Topic::$storeTopicRules;
    }

    protected function formatErrors(Validator $validator)
    {
        $messages = $validator->errors();


        if ($validator->fails()) {
            return redirect('admin#/topics')
                    ->withErrors($validator)
                    ->withInput();
        }
    }
}