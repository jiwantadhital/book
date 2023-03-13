@extends('backend.layout.backend')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-sm-6 col-md-9 col-lg-9">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{$title}} Forms
                                <a href="{{route($route .'index')}}" class="btn btn-success">Lists</a>
                            </h3>
                        </div>
        <!-- /.card-header -->
        <!-- form start -->
        {!! Form::open(['route' => $route .'store' , 'method' => 'post' , 'class' => 'form-horizontal','enctype'=>'multipart/form-data']) !!}
        @csrf

        <div class="card-body">
            <div class="form-group row">
                {!! Form::label('sem_id', 'Semester: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    {!! Form::select('sem_id', $data['sem'], null,['class' => 'form-control','placeholder' => 'Select Semester','id'=>'semester',]) !!}
                    @error('sem_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                {!! Form::label('sub_id', 'Subject: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    <select class="form-control  formselect required"  placeholder="Select Sub Category" name="sub_id" id="subject"></select>
                    @error('sub_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                {!! Form::label('chapter_id', 'Chapter: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
                <div class="col-sm-10">
                    <select class="form-control  formselect required"  placeholder="Select Chapter" name="chapter_id" id="chapter"></select>
                    @error('chapter_id')
                    <span class="text text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
            <textarea name="notes" id="summernote" cols="0" rows="0" hidden="true"></textarea>

            <div  class="document-editor">
       {!! Form::label('notes','Notes: <span class="required">*</span>',['class' => 'col-sm-2 col-form-label'],false); !!}
    <div class="document-editor__toolbar"></div>
    <div class="document-editor__editable-container">

        <div id="summernotes" class="document-editor__editable">
        </div>
    </div>
</div>
</div>
</div>







        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" >Submit</button>
        </div>
        {!! Form::close() !!}

    </div>
</div>






            </div>
            <!-- /.card -->
        </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('csss')
<style>
   .document-editor {
    border: 1px solid var(--ck-color-base-border);
    border-radius: var(--ck-border-radius);

    /* Set vertical boundaries for the document editor. */
    max-height: 700px;

    /* This element is a flex container for easier rendering. */
    display: flex;
    flex-flow: column nowrap;
}
.document-editor__toolbar {
    /* Make sure the toolbar container is always above the editable. */
    z-index: 1;

    /* Create the illusion of the toolbar floating over the editable. */
    box-shadow: 0 0 5px hsla( 0,0%,0%,.2 );

    /* Use the CKEditor CSS variables to keep the UI consistent. */
    border-bottom: 1px solid var(--ck-color-toolbar-border);
}

/* Adjust the look of the toolbar inside the container. */
.document-editor__toolbar .ck-toolbar {
    border: 0;
    border-radius: 0;
}
/* Make the editable container look like the inside of a native word processor application. */
.document-editor__editable-container {
    padding: calc( 2 * var(--ck-spacing-large) );
    background: var(--ck-color-base-foreground);

    /* Make it possible to scroll the "page" of the edited content. */
    overflow-y: scroll;
}

.document-editor__editable-container .ck-editor__editable {
    /* Set the dimensions of the "page". */
    width: 23.8cm;
    min-height: 21cm;

    /* Keep the "page" off the boundaries of the container. */
    padding: 1cm 2cm 2cm;

    border: 1px hsl( 0,0%,82.7% ) solid;
    border-radius: var(--ck-border-radius);
    background: white;

    /* The "page" should cast a slight shadow (3D illusion). */
    box-shadow: 0 0 5px hsla( 0,0%,0%,.1 );

    /* Center the "page". */
    margin: 0 auto;
}
.document-editor .ck-content,
.document-editor .ck-heading-dropdown .ck-list .ck-button__label {
    font: 16px/1.6 "Helvetica Neue", Helvetica, Arial, sans-serif;
}
It is recommended to use the .ck-content CSS class to visually style the content of the editor (headings, paragraphs, lists, etc.).

/* Adjust the headings dropdown to host some larger heading styles. */
.document-editor .ck-heading-dropdown .ck-list .ck-button__label {
    line-height: calc( 1.7 * var(--ck-line-height-base) * var(--ck-font-size-base) );
    min-width: 6em;
}

/* Scale down all heading previews because they are way too big to be presented in the UI.
Preserve the relative scale, though. */
.document-editor .ck-heading-dropdown .ck-list .ck-button:not(.ck-heading_paragraph) .ck-button__label {
    transform: scale(0.8);
    transform-origin: left;
}

/* Set the styles for "Heading 1". */
.document-editor .ck-content h2,
.document-editor .ck-heading-dropdown .ck-heading_heading1 .ck-button__label {
    font-size: 2.18em;
    font-weight: normal;
}

.document-editor .ck-content h2 {
    line-height: 1.37em;
    padding-top: .342em;
    margin-bottom: .142em;
}

/* Set the styles for "Heading 2". */
.document-editor .ck-content h3,
.document-editor .ck-heading-dropdown .ck-heading_heading2 .ck-button__label {
    font-size: 1.75em;
    font-weight: normal;
    color: hsl( 203, 100%, 50% );
}

.document-editor .ck-heading-dropdown .ck-heading_heading2.ck-on .ck-button__label {
    color: var(--ck-color-list-button-on-text);
}

/* Set the styles for "Heading 2". */
.document-editor .ck-content h3 {
    line-height: 1.86em;
    padding-top: .171em;
    margin-bottom: .357em;
}

/* Set the styles for "Heading 3". */
.document-editor .ck-content h4,
.document-editor .ck-heading-dropdown .ck-heading_heading3 .ck-button__label {
    font-size: 1.31em;
    font-weight: bold;
}

.document-editor .ck-content h4 {
    line-height: 1.24em;
    padding-top: .286em;
    margin-bottom: .952em;
}

/* Set the styles for "Paragraph". */
.document-editor .ck-content p {
    font-size: 1em;
    line-height: 1.63em;
    padding-top: .5em;
    margin-bottom: 1.13em;
}
/* Make the block quoted text serif with some additional spacing. */
.document-editor .ck-content blockquote {
    font-family: Georgia, serif;
    margin-left: calc( 2 * var(--ck-spacing-large) );
    margin-right: calc( 2 * var(--ck-spacing-large) );
}
    </style>
@endsection
@section('jss')


<script>
    DecoupledEditor
        .create( document.querySelector( '.document-editor__editable' ),
        {
                    ckfinder:{
                    uploadUrl: '{{route('admin.ckeditor.upload').'?_token='.csrf_token()}}'
                }
        } )
        .then( editor => {
            const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
            toolbarContainer.appendChild( editor.ui.view.toolbar.element );

            editor.model.document.on( 'change:data', () => {
                // Retrieve the updated content
                const content = editor.getData();
                
                const textarea = document.getElementById('summernote');
                textarea.value = content;
            } );
        } )
        .catch( error => {
            console.error( error );
        } );
        
</script>

    <script>
        $(document).ready(function () {
            $('#semester').on('change', function () {
                let id = $(this).val();
                $('#subject').empty();
                $('#subject').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: 'getSubCategories/' +id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#subject').empty();
                        $('#subject').append(`<option value="0" disabled selected>Select Subject*</option>`);
                        response.forEach(element => {
                            $('#subject').append(`<option value="${element['id']}">${element['title']}</option>`);
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#subject').on('change', function () {
                let id = $(this).val();
                $('#chapter').empty();
                $('#chapter').append(`<option value="0" disabled selected>Processing...</option>`);
                $.ajax({
                    type: 'GET',
                    url: 'getchapter/' +id,
                    success: function (response) {
                        var response = JSON.parse(response);
                        console.log(response);
                        $('#chapter').empty();
                        $('#chapter').append(`<option value="0" disabled selected>Select Chapter*</option>`);
                        response.forEach(element => {
                            $('#chapter').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });
            });
        });
    </script>

@endsection
