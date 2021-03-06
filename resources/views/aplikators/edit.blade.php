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
                        <h3 align="center" class="box-title m-2">Review Aplikator ID. {{ $user->vendor_user_id }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('aplikators.update', $user->ID) }}" enctype="multipart/form-data"
                                    method="POST">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group @if ($errors->has('user_picture_url')) has-error @endif">
                                        <div class="img">
                                            <img class="img-circle" style="margin-bottom:5px;" width="100" height="100"
                                                id="avatar" @if ($user->user_picture_url) src="{{ $user->user_picture_url }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('display_name')) has-error @endif">
                                        <label for="name-field">Nama</label>
                                        <input type="text" id="name-field" name="display_name" class="form-control"
                                            value="{{ is_null(old('vendor_name')) ? $user->display_name : old('display_name') }}" />
                                        @if ($errors->has('display_name'))
                                            <span class="help-block">{{ $errors->first('display_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('quality')) has-error @endif">
                                        <label for="triwulan-field">Quality</label>
                                        <select class="form-control" id="quality-field" name="quality">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['quality']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('quality'))
                                            <span class="help-block">{{ $errors->first('quality') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group{{ $errors->has('responsiveness_to_customer') ? ' has-error' : '' }}">
                                        <label for="responsiveness_to_customer">Responsiveness to customer</label>
                                        <select class="form-control" id="responsiveness_to_customer-field"
                                            name="responsiveness_to_customer">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['responsiveness_to_customer']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('responsiveness_to_customer'))
                                            <span
                                                class="help-block">{{ $errors->first('responsiveness_to_customer') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="form-group{{ $errors->has('responsiveness_to_mitraruma') ? ' has-error' : '' }}">
                                        <label for="responsiveness_to_mitraruma">Responsiveness to Mitraruma</label>
                                        <select class="form-control" id="responsiveness_to_mitraruma-field"
                                            name="responsiveness_to_mitraruma">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['responsiveness_to_mitraruma']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('responsiveness_to_mitraruma'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('responsiveness_to_mitraruma') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('behaviour') ? ' has-error' : '' }}">
                                        <label for="behaviour">Behavior</label>
                                        <select class="form-control" id="behaviour-field" name="behaviour">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['behaviour']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('behaviour'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('behaviour') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('helpful') ? ' has-error' : '' }}">
                                        <label for="helpful">Helpful</label>
                                        <select class="form-control" id="helpful-field" name="helpful">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['helpful']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('helpful'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('helpful') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('commitment') ? ' has-error' : '' }}">
                                        <label for="commitment">Commitment</label>
                                        <select class="form-control" id="commitment-field" name="commitment">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['commitment']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('commitment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('commitment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('activeness') ? ' has-error' : '' }}">
                                        <label for="activeness">Activeness</label>
                                        <select class="form-control" id="activeness-field" name="activeness">
                                            @foreach ($reviews as $key => $val)
                                                @if ($user->review)
                                                    <option value="{{ $key }}" @if ($key == $user->review['activeness']) selected @endif>
                                                        {{ $val }}</option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $val }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        @if ($errors->has('activeness'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('activeness') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="well well-sm mb-2">
                                        <button type="submit" value="Save" class="btn btn-primary pull-right right"> Save
                                        </button>
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
