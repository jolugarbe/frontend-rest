@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('site.includes.notifications')
                <div class="card">
                    <div class="card-header">{{Lang::get('Profile')}}</div>

                    <div class="card-body">
                        <form id="profile_form" action="{{URL::to('user/profile/update')}}" method="post">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="name">{{Lang::get('Name')}}</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Name" value="{{ old('name', Auth::check() ? Auth::user()->getName() : null)}}">
                                <div class="invalid-feedback">
                                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">{{Lang::get('Email')}}</label>
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" placeholder="Email" value="{{ old('email', Auth::check() ? Auth::user()->getEmail() : null)}}">
                                <div class="invalid-feedback">
                                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="exampleInputPassword1">Password</label>--}}
                                {{--<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">--}}
                            {{--</div>--}}
                            <button type="submit" class="btn btn-primary float-right">{{Lang::get('Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection