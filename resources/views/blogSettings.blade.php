@extends('baseplate')

@section('content')

<!-- Page Header -->
  <header class="masthead" id="topPicture" style="background-image: url('img/bg-prof.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Blog Settings</h1>
            <span class="subheading"></span><br><br>

          </div>
        </div>
      </div>
    </div>
  </header>

<!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-10 col-md-10 mx-auto">
        <div class="control-group">
          <div class="form-group floating-label-form-group controls" id="tag-list">
            <table style="width:100%;" id="tag-table">
              
            </table>
          </div>
        </div>
        <br>
        <div id="success" style="text-align:center;">Updated!</div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')
<script>
  $('#success').hide();
  function updateTags(data){
    $('#tag-table').html("");
    $('#tag-table').html(`
            <tr>
              <th>Tag ID</th>
              <th>Name</th>
              <th>Color</th>
              <th>Example</th>
            </tr>`);
    $.each(data, function( key, value ) {
      $('#tag-table').append(`
            <tr>
              <td>`+value.id+`</td>
              <td>`+value.name+`</td>
              <td>`+value.color+`</td>
              <td><a class="btn btn-primary btn-tag" href="#" style="background-color:#`+value.color+`;">`+value.name+`</a></td>
            </tr>`);
    });
    $('#tag-table').append(`
            <tr>
              <td><a class="btn-primary btn-sm" href="javascript:;" id="tag-add">+</a></td>
              <td><input type="text" class="form-control" placeholder="Tag Name" id="tag-name" aria-invalid="false"></td>
              <td><input type="text" class="form-control" placeholder="Tag Color" id="tag-color" aria-invalid="false"></td>
              <td id="example-button"></td>
            </tr>`)
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
        console.log(data);
        updateTags(data);
      },
      error: function(jq, err, status){
        console.log(jq);
        console.log(err);
        console.log(status);
      }
    });
  }

  function addTag(){
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    $.ajax({
      type: 'POST',
      url: '/ajax/addTag',
      data: {name: $('#tag-name').val(), color: $('#tag-color').val()},
      dataType: 'json',
      success: function (data) {
        console.log(data);
        getTags();
      },
      error: function(jq, err, status){
        console.log(jq);
        console.log(err);
        console.log(status);
      }
    });
  }
  $(document.body).on('input', '#tag-name' ,function(){
    if($('#tag-name').val() != "" && $('#tag-color').val() != ""){
      $('#example-button').html(`<a class="btn btn-primary" href="#" style="background-color:#`+$('#tag-color').val()+`; min-width:140px;">`+$('#tag-name').val()+`</a>`);
    }
  });
  $(document.body).on('input', '#tag-color' ,function(){
    if($('#tag-name').val() != "" && $('#tag-color').val() != ""){
      $('#example-button').html(`<a class="btn btn-primary" href="#" style="background-color:#`+$('#tag-color').val()+`; min-width:140px;">`+$('#tag-name').val()+`</a>`);
    }
  });

  $(document.body).on('click', '#tag-add' ,function(){
    if($('#tag-name').val() != "" && $('#tag-color').val() != ""){
      addTag();
    }
  });
  getTags();

</script>

@endsection