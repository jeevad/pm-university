<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TopicRequest extends Request {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [ 
				'source_url' => 'required|url|max:255',
				'title' => 'required|max:255',
				'description' => 'required|max:65000',
				'topic_picture' => 'sometimes',
				'level_id' => 'required|exists:levels,id',
				'file' => 'sometimes|image',
				'author_name' => 'sometimes|full_name',
				'author_description' => 'sometimes',
				'author_picture' => 'sometimes|image',
				'h1' => 'sometimes',
				'meta_title' => 'sometimes',
				'meta_description' => 'sometimes',
				'meta_keywords' => 'sometimes' 
		];
	}
}
