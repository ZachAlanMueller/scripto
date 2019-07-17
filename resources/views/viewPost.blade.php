@extends('baseplate')
@section('content')
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
               <h1 id="post-title" contenteditable="false">{{$postInfo->title}}</h1>
               <span class="subheading"></span><br><br>
            </div>
         </div>
      </div>
   </div>
</header>
<!-- Main Content -->
<br>
<div id="container-preview" class="container">
   <div id="preview-holder">{!!$postInfo->content!!}</div>
   <br>
   <div class="float-right" style="color:#504848;font-size:12px;">{{$postInfo->name}}</div><br>
   <div class="float-right" style="color:#504848;font-size:12px;">{{$date}}</div>
</div>
<br><br>
@endsection
@section('javascript')
<script>
     
</script>
@endsection