<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Topic;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiControllerTrait;

class StoreTopicRequest extends Request
{

    use ApiControllerTrait;

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
        if ($validator->fails()) {


            $errors = formatValidationMessages((object)$validator->errors()->all());
            return $this->respondWithValidationError('Validation failed',
                    $errors);
        }
    }
}