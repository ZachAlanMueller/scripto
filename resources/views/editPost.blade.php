@extends('baseplate')
@section('content')
{{header("Cache-Control: no-cache, no-store, must-revalidate")}}
<style>
  #post-title:hover {
    cursor: pointer;
  }
  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  .switch {
    position: relative;
    display: inline-block;
    width: 120px;
    height: 34px;
  }
  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #17a2b8;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #28a745;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #28a745;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(86px);
    -ms-transform: translateX(86px);
    transform: translateX(86px);
  }
  .slider:after
  {
    font-weight: bold;
    content:'PRIVATE';
    color: white;
    display: block;
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    font-size: 10px;
    font-family: Verdana, sans-serif;
  }

  input:checked + .slider:after
  {  
    font-weight: bold;
    content:'PUBLIC';
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
  .vertical-center {
    margin: 0;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
  }
</style>
<!-- Page Header -->
<header class="masthead" id="topPicture" style="background-image: url('/img/bg-prof.jpg')">
   <div class="overlay"></div>
   <div class="container">
      <div class="row">
         <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
               <h1 id="post-title" contenteditable="true">{{$draft->title}}</h1>
               <span class="subheading"></span><br><br>
            </div>
         </div>
      </div>
   </div>
</header>
<!-- Main Content -->
<br>
<div id="container-editor" class="container">
   <div id="snow-container" class="ql-container ql-snow">
   </div>
</div>
<br>
<div id="container-options" class="container">
   <div class="row">
      <div class="col-lg-8">
      </div>
      <div class="col-lg-4">
      </div>
   </div>
   <div class="row" style="margin-bottom: 4px;">
      <div class="col-md-6">
        <select class="tokenize-tags" multiple></select>
        <div id="tags-warning" class="alert alert-warning" style="font-size: 14px;">Need to add tags before saving</div>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-3">
        <label class="switch float-right vertical-center">
          <input type="checkbox" id="public" checked>
          <span class="slider round">
          </span>
        </label>
      </div>
   </div>
   <div class="row">
      <div class="col-md-4"><a href="javascript:;" id="draft"><button class="btn btn-warning">Save as Draft</button></a></div>
      <div class="col-md-2"></div>
      <div class="col-md-3"><a href="javascript:;" class="float-right preview-switcher"><button class="btn btn-info">Preview</button></a></div>
      <div class="col-md-3"><a href="javascript:;" class="float-right" id="publish"><button class="btn btn-success">Publish</button></a></div>
   </div>
</div>
<div id="container-preview" class="container">
   <div id="preview-holder"></div>
   <br>
   <div class="float-right" style="color:#504848;font-size:12px;">{{Auth::user()->name}}</div><br>
   <div class="float-right" style="color:#504848;font-size:12px;">{{date('F jS Y')}}</div><br><br><br>
   <a href="javascript:;" class="float-right preview-switcher"><button class="btn btn-info">Back to Editor</button></a>
</div>
<br><br>
@endsection
@section('javascript')
<script>
   @if (isset($post_id))
   var post_id = {{$post_id}};
   @else
   var post_id = 0;
   @endif
   var private = 0;
   var draft = 1;
   var title = "";
   var content = "";
   var tags;
   var toolbarOptions = [
     ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
     ['blockquote', 'code-block'],
   
     [{ 'header': 1 }, { 'header': 2 }],               // custom button values
     [{ 'list': 'ordered'}, { 'list': 'bullet' }],
     [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
     [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
     [{ 'direction': 'rtl' }],                         // text direction
   
     [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
     [ 'link', 'image', 'video', 'formula' ],          // add's image support
     [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
     [{ 'font': [] }],
     [{ 'align': [] }],
   
     ['clean']                                         // remove formatting button
   ];
   
   var snowQuill = new Quill('#snow-container', {
     placeholder: 'Compose an epic...',
     modules: {
       toolbar: toolbarOptions
     },
     theme: 'snow'
   });
   snowQuill.root.innerHTML = `{!!$draft->content!!}`
   function savePost(){
    if( $('input#public').is(':checked') ){
      private = 0;
    }
    else {
      private = 1;
    }
    title = $('#post-title').html();
    content = $('.ql-editor').html();
    tags = $('.tokenize-tags').val();
    if(tags.length == 0){
      $('#tags-warning').show(500).delay(1000).hide(500);
    }
    else{
      $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       })
       $.ajax({
         type: 'POST',
         url: '/ajax/savePost',
         data: { post_id: post_id, title: title, content: content, draft: draft, private: private, tags: tags},
         dataType: 'json',
         success: function (data) {
           console.log(data);
           if(draft == 1){
            window.location.href = "/post/drafts";
           }
           else{
            window.location.href = "/post/"+data;
           }
         },
         error: function(jq, err, status){
           console.log(jq);
           console.log(err);
           console.log(status);
         }
       });
    }
     
   }
   function getTags(){
     $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     })
     $.ajax({
       type: 'POST',
       url: '/ajax/getTags',
       dataType: 'json',
       success: function (data) {
        //console.log(data);
        setupTags(data);
       },
       error: function(jq, err, status){
         console.log(jq);
         console.log(err);
         console.log(status);
       }
     });
   }
   function setupTags(data){
    $.each(data, function(i){
      @foreach($tags as $tag)
      var tmp = "{{$tag->name}}";
      if(tmp == data[i]['name']){
        $('.tokenize-tags').append(`<option selected value="`+data[i]['id']+`">`+data[i]['name']+`</option>`);
      }else{
        $('.tokenize-tags').append(`<option value="`+data[i]['id']+`">`+data[i]['name']+`</option>`);
      }
      @endforeach
      //$('.tokenize-tags').append(`<option value="`+data[i]['id']+`">`+data[i]['name']+`</option>`);
    })
    $('.tokenize-tags').tokenize2();
   }
   $('#draft').click(function(){
     draft = 1;
     savePost();
   });
   $('#publish').click(function(){
     draft = 0;
     savePost();
   });
   $('.preview-switcher').click(function(){
     $('#preview-holder').html($('.ql-editor').html());
     $('#container-preview').toggle(200);
     $('#container-options').toggle(200);
     $('#container-editor').toggle(200);
   });
   $('#tags-warning').hide();
   $('#container-preview').hide();
   getTags();
</script>
<script type="text/javascript">
  $(window).on('beforeunload', function(){
    var c=confirm();
    if(c){
      return true;
    }
    else
      return false;
    });
</script>
@endsection