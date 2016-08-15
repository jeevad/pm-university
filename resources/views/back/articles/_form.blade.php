<div role="tabpanel">
	<ul class="tab-nav" role="tablist">
		<li class="active"><a href="#content1" aria-controls="content1"
			role="tab" data-toggle="tab">Content</a></li>
		<li><a href="#author" aria-controls="author" role="tab"
			data-toggle="tab">Author</a></li>

	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="content1">
			<div class="form-group {{ classHasError($errors, 'type_id') }}">
				<div class="fg-line">
					<p class="f-500 m-b-15">{!! Form::label('article_type_id', 'Type',
						classControlLabel($errors, 'article_type_id')) !!}</p>
					{!! Form::select('article_type_id', array('1' => 'Books', '2' => 'Videos', '3'=> 'Interviews', '4' => 'Notes'), null,
					['placeholder' => 'Choose a article type...', 'class'=> "chosen"])
					!!}
				</div>
				{!! classHelperBlock($errors, 'article_type_id') !!}
			</div>

			<div class="form-group {{ classHasError($errors, 'source_url') }}">
				<div class="fg-line">{!! Form::label('source_url', 'Source URL',
					classControlLabel($errors, 'source_url')) !!} {!!
					Form::text('source_url', old('source_url'),array('class' =>
					'form-control input-sm', 'id'=> 'source_url', 'placeholder' =>
					'Enter URL')) !!}</div>

				{!! classHelperBlock($errors, 'source_url') !!}
			</div>
			<div class="form-group {{ classHasError($errors, 'title') }}">
				<div class="fg-line">{!! Form::label('title', 'Title',
					classControlLabel($errors, 'title')) !!} {!! Form::text('title',
					old('title'),array('class' => 'form-control input-sm', 'id'=>
					'title', 'placeholder' => 'Enter Title')) !!}</div>
				{!! classHelperBlock($errors, 'title') !!}
			</div>
			<div class="form-group {{ classHasError($errors, 'description') }}">
				<div class="fg-line">{!! Form::label('description', 'Description',
					classControlLabel($errors, 'description')) !!} {!!
					Form::text('description', old('description'),array('class' =>
					'form-control input-lg', 'id'=> 'description', 'placeholder' =>
					'Enter Description')) !!}</div>
				{!! classHelperBlock($errors, 'description') !!}
			</div>
			<div class="checkbox">
				<label> {!! Form::checkbox('publish', '') !!} <i
					class="input-helper"></i> Mark to publish
				</label>
			</div>


		</div>

		<div role="tabpanel" class="tab-pane" id="author">
			<div class="form-group fg-line">{!! Form::label('author_name',
				'Author Name') !!} {!! Form::text('author_name',
				old('author_name'),array('class' => 'form-control input-sm', 'id'=>
				'author_name', 'placeholder' => 'Enter author name')) !!}</div>
			<div class="form-group fg-line">{!! Form::label('author_description',
				'Author Description') !!} {!! Form::text('author_description',
				old('author_description'),array('class' => 'form-control input-sm',
				'id'=> 'author_description', 'placeholder' => 'Enter author
				description')) !!}</div>

		</div>

	</div>
</div>
<button type="submit" class="btn btn-primary btn-sm m-t-10">{{
	$submitButtonText }}</button>