@extends('layouts.app')

@section('title')Edit Pengguna
@endsection

@section('content')

    <div class="row">
        <div class="container col-sm-12">
            <div class="col-md-10">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @elseif(session('gagal'))
                    <div class="alert alert-danger">
                        {{ session('gagal') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Errors!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="box">
                    <div class="box-header">
                        <h3 align="center" class="box-title m-2">Pengguna ID:  {{$user->ID }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                
                                <form action="{{ route('users.update', $user) }}" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group @if($errors->has('user_picture_url')) has-error @endif">
                                            <div class="img">
                                                <img class="img-circle" style="margin-bottom:5px;" width="100" height="100" id="avatar" @if($user->user_picture_url) src="{{ $user->user_picture_url }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
                                                <br>
                                                <input type="file" id="user_picture_url" name="user_picture_url" accept="image/x-png,image/gif,image/jpeg" onchange="loadFile(event)">
                                                @if ($errors->has('user_picture_url'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_picture_url') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group @if($errors->has('display_name')) has-error @endif">
                                           <label for="name-field">Nama</label>
                                        <input type="text" id="name-field" name="display_name" class="form-control" value="{{ is_null(old("display_name")) ? $user->display_name : old("display_name") }}"/>
                                           @if($errors->has("display_name"))
                                            <span class="help-block">{{ $errors->first("display_name") }}</span>
                                           @endif
                                        </div>
                    
                                        <div class="form-group @if($errors->has('user_email')) has-error @endif">
                                           <label for="user_email-field">user_email</label>
                                        <input type="text" id="user_email-field" name="user_email" class="form-control" value="{{ is_null(old("user_email")) ? $user->user_email : old("user_email") }}"/>
                                           @if($errors->has("user_email"))
                                            <span class="help-block">{{ $errors->first("user_email") }}</span>
                                           @endif
                                        </div>
                                        <div class="form-group @if($errors->has('user_phone_number')) has-error @endif">
                                           <label for="user_phone_number-field">Nomor kontak</label>
                                        <input type="text" id="user_phone_number-field" name='user_phone_number' class="form-control" value="{{ is_null(old('user_phone_number')) ? $user->user_phone_number : old('user_phone_number') }}"/>
                                           @if($errors->has('user_phone_number'))
                                            <span class="help-block">{{ $errors->first('user_phone_number') }}</span>
                                           @endif
                                        </div>
                                        <div class="form-group @if($errors->has('skill_set')) has-error @endif">
                                           <label for="triwulan-field">Skill Set</label>
                                            <select class="form-control" id="skill_set-field" name="skill_set">                    
                                                <option value="">Pilih skill Set</option>
                                                {{-- @foreach($skill_sets as $p)
                                                    <option value="{{ $p->id }}" @if($user->skill_set==$p->id) selected @endif>{{ $p->name }}</option>
                                                @endforeach --}}
                                                </select>                       
                                           @if($errors->has("skill_set"))
                                            <span class="help-block">{{ $errors->first("skill_set") }}</span>
                                           @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('coverage-area') ? ' has-error' : '' }}">
                                            <label for="coverage-area" >Coverage Area</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="">Pilih coverage area</option>
                                                {{-- @foreach($skill_sets as $p)
                                                    <option value="{{ $p->id }}" @if($user->skill_set==$p->id) selected @endif>{{ $p->name }}</option>
                                                @endforeach --}}
                                                </select>                       
                                           @if($errors->has("coverage-area"))
                                            <span class="help-block">{{ $errors->first("coverage-area") }}</span>
                                           @endif                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation" >Customer Segmentation</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="">Pilih customer segmentation</option>
                                                {{-- @foreach($skill_sets as $p)
                                                    <option value="{{ $p->id }}" @if($user->skill_set==$p->id) selected @endif>{{ $p->name }}</option>
                                                @endforeach --}}
                                                </select>                                                                           
                                                @if ($errors->has('customer_segmentation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
