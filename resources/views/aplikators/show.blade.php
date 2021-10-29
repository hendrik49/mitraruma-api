@extends('layouts.app')

@section('title')Show Pengguna
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
                        <h3 align="center" class="box-title m-2">Review Aplikator ID.  {{$user->vendor_user_id }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">                
                                <form action="{{ route('aplikators.update', $user) }}" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group @if($errors->has('user_picture_url')) has-error @endif">
                                            <div class="img">
                                                <img class="img-circle" style="margin-bottom:5px;" width="100" height="100" id="avatar" @if($user->vendor['user_picture_url']) src="{{ $user->vendor['user_picture_url'] }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group @if($errors->has('vendor_name')) has-error @endif">
                                           <label for="name-field">Nama</label>
                                        <input type="text" id="name-field" name="vendor_name" class="form-control" value="{{ is_null(old("vendor_name")) ? $user->vendor_name : old("vendor_name") }}"/>
                                           @if($errors->has("vendor_name"))
                                            <span class="help-block">{{ $errors->first("vendor_name") }}</span>
                                           @endif
                                        </div>
                                        <div class="form-group @if($errors->has('skill_set')) has-error @endif">
                                           <label for="triwulan-field">Quality</label>
                                                <select class="form-control" id="skill_set-field" name="skill_set">                    
                                                    <option value="1">Kurang</option>
                                                    <option value="2">Cukup</option>
                                                    <option value="3">Baik</option>
                                                    <option value="4">Sangat Baik</option>
                                                    <option value="5">Hebat</option>
                                                </select>                       
                                           @if($errors->has("skill_set"))
                                            <span class="help-block">{{ $errors->first("skill_set") }}</span>
                                           @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('coverage-area') ? ' has-error' : '' }}">
                                            <label for="coverage-area" >Responsiveness to customer</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="1">Kurang</option>
                                                <option value="2">Cukup</option>
                                                <option value="3">Baik</option>
                                                <option value="4">Sangat Baik</option>
                                                <option value="5">Hebat</option>
                                            </select>                       
                                        </select>                      
                                           @if($errors->has("coverage-area"))
                                            <span class="help-block">{{ $errors->first("coverage-area") }}</span>
                                           @endif                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation" >Responsiveness to Mitraruma</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="1">Kurang</option>
                                                <option value="2">Cukup</option>
                                                <option value="3">Baik</option>
                                                <option value="4">Sangat Baik</option>
                                                <option value="5">Hebat</option>
                                            </select>                       
                                            </select>                                                                       
                                            @if ($errors->has('customer_segmentation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation">Behavior</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="1">Kurang</option>
                                                <option value="2">Cukup</option>
                                                <option value="3">Baik</option>
                                                <option value="4">Sangat Baik</option>
                                                <option value="5">Hebat</option>
                                            </select>                       

                                            </select>                                                                       
                                            @if ($errors->has('customer_segmentation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation">Helpful</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="1">Kurang</option>
                                                <option value="2">Cukup</option>
                                                <option value="3">Baik</option>
                                                <option value="4">Sangat Baik</option>
                                                <option value="5">Hebat</option>
                                            </select>                       

                                            </select>                                                                       
                                            @if ($errors->has('customer_segmentation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation">Commitment</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="1">Kurang</option>
                                                <option value="2">Cukup</option>
                                                <option value="3">Baik</option>
                                                <option value="4">Sangat Baik</option>
                                                <option value="5">Hebat</option>
                                            </select>                       
                                            </select>                                                                       
                                            @if ($errors->has('customer_segmentation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation">Activeness</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">                    
                                                <option value="1">Kurang</option>
                                                <option value="2">Cukup</option>
                                                <option value="3">Baik</option>
                                                <option value="4">Sangat Baik</option>
                                                <option value="5">Hebat</option>
                                            </select>                       

                                            </select>                                                                       
                                            @if ($errors->has('customer_segmentation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                </span>
                                            @endif
                                        </div>                                      
                                    <div class="well well-sm mb-2">
                                        <button type="submit" value="Save" class="btn btn-primary pull-right right"> Save </button>
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
