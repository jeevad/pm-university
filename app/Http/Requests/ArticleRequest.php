<?php

namespace App\Http\Requests;

class ArticleRequest extends Request
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
        return [
                'topic_id'           => 'required|exists:topics,id',
                'article_type_id'    => 'required|exists:article_types,id',
                'source_url'         => 'required|url|max:255',
                'title'              => 'required|max:255',
                'description'        => 'required|max:65000',
                'author_name'        => 'sometimes|full_name',
                'author_description' => 'sometimes',
                'author_picture'     => 'sometimes|image',
        ];
    }
}
