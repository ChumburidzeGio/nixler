@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                 <div class="panel-body _pb5 _bb1">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group _m0 _mb10{{ $errors->has('name') ? ' has-error' : '' }}">

                                <input id="name" type="text" class="_b1 _bcg _fe _brds3" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">

                                @if ($errors->has('name'))
                                    <span class="help-block _mb _mt0">
                                        <span class="_fs13 _lh1">{{ $errors->first('name') }}</span>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group _m0 _mb10{{ $errors->has('email') ? ' has-error' : '' }}">

                                <input id="email" type="email" class="_b1 _bcg _fe _brds3" name="email" value="{{ old('email') }}" required placeholder="Email">

                                @if ($errors->has('email'))
                                    <span class="help-block _mb _mt0">
                                       <span class="_fs13 _lh1">{{ $errors->first('email') }}</span>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group _m0 _mb10{{ $errors->has('password') ? ' has-error' : '' }}">

                                <input id="password" type="password" class="_b1 _bcg _fe _brds3" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block _mb _mt0">
                                        <span class="_fs13 _lh1">{{ $errors->first('password') }}</span>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group _m0">

                                <input id="password-confirm" type="password" class="_b1 _bcg _fe _brds3" name="password_confirmation" required placeholder="Confirm Password">
                        </div>

                         <button type="submit" class="_btn _bgi _cw _mt15 block">Join us</button>
                        
                        <p class="_clear _fw600 _fs12 _p10 _cbt9 _mt10 _tac _mb0">
                            Already have an account ? <a class="_cbl" href="{{ url('login') }}"> Log in</a>
                        </p>

                    </form>
                </div>

                    <div class="_tac _mb15">

                        <a href="{{ url('/auth/facebook') }}" class="_btn _bgi _cw _mt15 _z013 _pt5 _pb5 _thvrw" style="background:#3b5998">
                            <img class="_mr5 _va3 _brds1" src="/img/facebook-lite.svg" height="15px"> 
                            Sign in with Facebook
                        </a>

                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
