@extends('layouts.app')
@section('content')
<style type="text/css">
    input.form-control.cstm_form_cls_login {
    background: #f6f7f7;
    border-radius: 0px;
    padding: 18px 16px;
    outline: 0;
    box-shadow: none;
    width: 65%;
    border: none;
    /* text-align: center; */
    margin: 0 auto;
}

</style>
<div class="container">
 <div class="row">
  <div class="mainn_wrapperr">
    {{-- main div --}}

   <div class="col-md-12">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <div class="asc">
    {{-- </div> --}}
    <center>
     <div class="panel-heading">
       <span class="admin_text">admin</span><span class="panel_text">panel</span>
     </div>
    </center>
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <div class="class_centerr">
       <div class="form-group{{ $errors->has('email') ? ' has-error':''}}">
        <label for="email" class="col-md-3 control-label"></label>
        <div class="col-md-6">
         <input id="email" type="email" class="form-control cstm_form_cls_login" placeholder="Enter your email" name="email" value="{{ old('email') }}" required autofocus>
           @if ($errors->has('email'))
             <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
             </span>
           @endif
        </div>
       </div>
       <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
         <label for="password" class="col-md-3 control-label"></label>
         <div class="col-md-6">
          <input id="password" type="text" placeholder="Enter your password" class="form-control cstm_form_cls_login" name="password" required>
        
         </div>
         
       </div>
       <a class="btn btn-link forgot_link" href="#">Forgot Password ?
       </a>
      </div>
      <div class="form-group">
       <div class="col-md-12">
        <button type="submit" class="btn btn-primary login_under">
              Login
        </button>
       </div>
      </div>
    </form>
</div>
   </div>
    <div class="col-md-3">
    </div>

   </div>
   {{-- #3097d1 --}}
   {{-- main div --}}
  </div>
 </div>
</div>


@endsection
