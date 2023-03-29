{!! Form::model($faq, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'col s12', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body"> 
    <?php $x = 0; ?>
    @foreach ($languages as $key => $language )
    @if($key==config('settings.default_language') || $key=='en')
    <div class="form-group m-form__group row">
      
        <label for="example-text-input" class="col-3 col-form-label">
            Question In {{$language['title']}}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('question['.$key.']', old('question['.$key.']', $faq->question[$key]), ['class' => 'form-control', 'required'=>'required','placeholder' =>  'Question']) !!}

        </div>
    </div> 
    @if($x==1)
    {{-- <button type="button" class="Add-field">More Question Translations</button> --}}
   
    @endif
    <?php $x++; ?>
    @else
<div class="lang-input">
    
    <div class="form-group m-form__group row ">
      
        <label for="example-text-input" class="col-3 col-form-label">
            Question In {{$language['title']}}
 
        </label>
        <div class="col-7">
            {!! Form::text('question['.$key.']', old('question['.$key.']', $faq->question[$key]), ['class' => 'form-control','placeholder' =>  'Question']) !!}

        </div>
    </div> 
</div>
    @endif
    @endforeach 

    {{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Question In Arabic
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('question[ar]', old('question[en]', $faq->question['ar']), ['class' => 'form-control', 'required'=>'required','placeholder' =>  'Question']) !!}
        </div>
    </div> --}}
    <?php $x=0; ?>
    @foreach ($languages as $key => $language )
    @if($key==config('settings.default_language') || $key=='en')
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Answer In {{$language['title']}}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('answer['.$key.']', old('question['.$key.']', $faq->answer[$key]), ['class' => 'form-control','required'=>'required','placeholder' =>  'Answer']) !!}
        </div>
    </div>
    @if($x==1)
    {{-- <button type="button" class="Add-new-field">More Answer Translations</button> --}}
   
    @endif
    <?php $x++; ?>
    @else
 <div class="lang-new-input ">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Answer In {{$language['title']}}
        </label>
        <div class="col-7">
            {!! Form::textarea('answer['.$key.']', old('question['.$key.']', $faq->answer[$key]), ['class' => 'form-control','placeholder' =>  'Answer']) !!}
        </div>
    </div>
 </div>
    @endif
    @endforeach
    {{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Answer In English
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::textarea('answer[ar]', old('question[en]', $faq->answer['ar']), ['class' => 'form-control','required'=>'required','placeholder' =>  'Answer']) !!}
        </div>
    </div> --}}

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{!! $languageId !!}" name="language_id">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom button-margin">
                    @if($faqId == 0)
                        Add FAQ
                    @else
                        Save Changes
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.faqs.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}



