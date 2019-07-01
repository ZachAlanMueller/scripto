@extends('baseplate')

@section('content')

<!-- Page Header -->
  <header class="masthead" id="topPicture" style="background-image: url('img/bg-prof.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Zach Mueller</h1>
            <span class="subheading">Profile</span><br><br>
            <div class="row">
            <div class="col-md-4"><a href="/blogSettings"><button class="btn btn-primary" >Blog Settings</button></a></div>
            <div class="col-md-4"><a href="/newPost"><button class="btn btn-success">New Post</button></a></div>
            <div class="col-md-4"><a href="/logout"><button class="btn btn-primary" >Logout</button></a></div>

          </div>
        </div>
      </div>
    </div>
  </header>

<!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="control-group">
          <div class="form-group floating-label-form-group controls row">
            <div class="col-sm-8">
              <label>Name</label>
              <input type="text" class="form-control" placeholder="Name" id="name" required="" data-validation-required-message="Please enter your name." value="{{Auth::user()->name}}">
              <p class="help-block text-danger"></p>
            </div>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-primary" id="nameUpdateButton">Update Name</button>
            </div>
          </div>
        </div>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls row">
            <div class="col-sm-8">
              <label>Email Address</label>
              <input type="email" class="form-control" placeholder="Email Address" id="email" required="" data-validation-required-message="Please enter your email address." value="{{Auth::user()->email}}">
              <p class="help-block text-danger"></p>
            </div>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-primary" id="emailUpdateButton">Update E-mail</button>
            </div>
          </div>
        </div>
        <div class="control-group">
          <div class="form-group floating-label-form-group controls row">
            <div class="col-sm-8">
              <label>Update Password</label>
              <input type="password" class="form-control" placeholder="New Password" id="password" required="" data-validation-required-message="Please enter your password." value="">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-8">
              <label id="passwordConfirmLabel">Confirm Password</label>
              <input type="password" class="form-control" placeholder="Confirm Password" id="passwordConfirm" required="" data-validation-required-message="Please enter your password." value="">
            </div>
            <div class="col-sm-4" id="passwordUpdate">
              <button type="submit" class="btn btn-primary" id="passwordUpdateButton">Update Password</button>
            </div>
            <p id="passwordConfirmToast" class="help-block text-danger"></p>
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
  var dataBlock = {password: '', username: '', email: ''};
  $('#passwordConfirm').hide();
  $('#passwordConfirmLabel').hide();
  $('#passwordUpdate').hide();
  $('#success').hide();
  //$('#password').focus(function(){alert('test')});

  $('#password').bind('input', function(){
    if($('#password').val() != ""){
      $('#passwordConfirm').show();
      $('#passwordConfirmLabel').show();
      $('#passwordUpdate').show();
    }
    else{
      $('#passwordConfirm').hide();
      $('#passwordConfirmLabel').hide();
      $('#passwordUpdate').hide();
    }
  });
  $('#passwordConfirm').bind('input', function(){
    if(($('#password').val() != $('#passwordConfirm').val()) && ($('#passwordConfirm').val().length > 7)){
      $('#passwordConfirmToast').html('Passwords Don\'t Match');
    }
    else{
      $('#passwordConfirmToast').html('');
    }
  });
  var matchingPasswords = 0;
  $('#passwordConfirm').bind('input', function(){
    if($('#password').val() == $('#passwordConfirm').val()){
      matchingPasswords = 1;
    }
    else{
      matchingPasswords = 0;
    }
  });
  
  $('#passwordUpdateButton').on('click', function(){
    if(matchingPasswords == 1){
      dataBlock['password'] = $('#password').val();
      updateUser();
    }
  });
  $('#emailUpdateButton').on('click', function(){
    dataBlock['email'] = $('#email').val();
    updateUser();
  });
  $('#nameUpdateButton').on('click', function(){
    dataBlock['name'] = $('#name').val();
    updateUser();
  });


  function updateUser(){
    console.log(dataBlock);
    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    $.ajax({
      type: 'POST',
      url: '/ajax/updateUser',
      data: dataBlock,
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $('#success').show(500).delay(1000).hide(500);
      },
      error: function(jq, err, status){
        console.log(jq);
        console.log(err);
        console.log(status);
      }
    });
  }
</script>

@endsection