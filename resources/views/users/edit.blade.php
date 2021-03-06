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
                        <h3 align="center" class="box-title m-2">Pengguna ID: {{ $user->ID }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('users.update', $user) }}" enctype="multipart/form-data"
                                    method="POST">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group @if ($errors->has('user_picture_url')) has-error @endif">
                                        <div class="img">
                                            <img class="img-circle" style="margin-bottom:5px;" width="100" height="100"
                                                id="avatar" @if ($user->user_picture_url) src="{{ $user->user_picture_url }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
                                            <br>
                                            <input type="file" id="user_picture_url" name="user_picture_url"
                                                accept="image/x-png,image/gif,image/jpeg" onchange="loadFile(event)">
                                            @if ($errors->has('user_picture_url'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('user_picture_url') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('display_name')) has-error @endif">
                                        <label for="name-field">Nama</label>
                                        <input type="text" id="name-field" name="display_name" class="form-control"
                                            value="{{ is_null(old('display_name')) ? $user->display_name : old('display_name') }}" />
                                        @if ($errors->has('display_name'))
                                            <span class="help-block">{{ $errors->first('display_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('user_type')) has-error @endif">
                                        <label for="name-field">Role</label>
                                            <select class="form-control" id="user_type" name="user_type">
                                                <option value="vendor" @if ($user->user_type == 'vendor') selected='selected' @endif>Aplikator</option>
                                                <option value="customer" @if ($user->user_type == 'customer') selected='selected' @endif>Customer</option>
                                            </select>
                                        @if ($errors->has('user_type'))
                                            <span class="help-block">{{ $errors->first('user_type') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('nik')) has-error @endif">
                                        <label for="nik-field">NIK KTP</label>
                                        <input type="text" id="nik-field" name="nik" class="form-control"
                                            value="{{ is_null(old('nik')) ? $user->nik : old('nik') }}" />
                                        @if ($errors->has('nik'))
                                            <span class="help-block">{{ $errors->first('nik') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('file_nik')) has-error @endif">
                                        <label for="nik-field">File KTP</label>
                                        <input type="file" id="file_nik-field" name="file_nik" class="form-control"
                                            value="{{ is_null(old('file_nik')) ? $user->file_nik : old('file_nik') }}" />
                                        @if ($errors->has('file_nik'))
                                            <span class="help-block">{{ $errors->first('file_nik') }}</span>
                                        @endif
                                        <div class="img mt-2">
                                            <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                height="100" id="avatar" @if ($user->file_nik) src="{{ $user->file_nik }}" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('npwp')) has-error @endif">
                                        <label for="npwp-field">No. NPWP</label>
                                        <input type="text" id="npwp-field" name="npwp" class="form-control"
                                            value="{{ is_null(old('npwp')) ? $user->npwp : old('npwp') }}" />
                                        @if ($errors->has('npwp'))
                                            <span class="help-block">{{ $errors->first('npwp') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('file_npwp')) has-error @endif">
                                        <label for="nik-field">File NPWP</label>
                                        <input type="file" id="npwp-field" name="file_npwp" class="form-control"
                                            value="{{ is_null(old('file_npwp')) ? $user->file_npwp : old('file_npwp') }}" />
                                        @if ($errors->has('file_npwp'))
                                            <span class="help-block">{{ $errors->first('file_npwp') }}</span>
                                        @endif
                                        <div class="img mt-2">
                                            <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                height="100" id="avatar" @if ($user->file_npwp) src="{{ $user->file_npwp }}" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group @if ($errors->has('user_email')) has-error @endif">
                                        <label for="user_email-field">Email</label>
                                        <input type="text" id="user_email-field" name="user_email" class="form-control"
                                            value="{{ is_null(old('user_email')) ? $user->user_email : old('user_email') }}" />
                                        @if ($errors->has('user_email'))
                                            <span class="help-block">{{ $errors->first('user_email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('user_phone_number')) has-error @endif">
                                        <label for="user_phone_number-field">Nomor kontak</label>
                                        <input type="text" id="user_phone_number-field" name='user_phone_number'
                                            class="form-control"
                                            value="{{ is_null(old('user_phone_number')) ? $user->user_phone_number : old('user_phone_number') }}" />
                                        @if ($errors->has('user_phone_number'))
                                            <span class="help-block">{{ $errors->first('user_phone_number') }}</span>
                                        @endif
                                    </div>
                                    @if ($user->user_type == 'vendor')
                                        <div class="form-group @if ($errors->has('bank')) has-error @endif">
                                            <label for="name-field">Bank</label>
                                            <input type="text" id="name-field" name="bank" class="form-control"
                                                value="{{ is_null(old('bank')) ? $user->bank : old('bank') }}" />
                                            @if ($errors->has('bank'))
                                                <span class="help-block">{{ $errors->first('bank') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('bank_account')) has-error @endif">
                                            <label for="nik-field">No. Rekening</label>
                                            <input type="text" id="bank_account-field" name="bank_account"
                                                class="form-control"
                                                value="{{ is_null(old('bank_account')) ? $user->bank_account : old('bank_account') }}" />
                                            @if ($errors->has('bank_account'))
                                                <span class="help-block">{{ $errors->first('bank_account') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('file_bank')) has-error @endif">
                                            <label for="nik-field">File Tabungan</label>
                                            <input type="file" id="file_bank-field" name="file_bank" class="form-control"
                                                value="{{ is_null(old('file_bank')) ? $user->file_bank : old('file_bank') }}" />
                                            @if ($errors->has('file_bank'))
                                                <span class="help-block">{{ $errors->first('file_bank') }}</span>
                                            @endif
                                            <div class="img mt-2">
                                                <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                    height="100" id="avatar" @if ($user->file_bank) src="{{ $user->file_bank }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group @if ($errors->has('capacity')) has-error @endif">
                                            <label for="name-field">Kapasitas</label>
                                            <input type="number" id="name-field" name="capacity" class="form-control"
                                                value="{{ is_null(old('capacity')) ? $user->capacity : old('capacity') }}" />
                                            @if ($errors->has('capacitye'))
                                                <span class="help-block">{{ $errors->first('capacity') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('portfolio')) has-error @endif">
                                            <label for="nik-field">Portfolio</label>
                                            <input type="file" id="npwp-field" name="portfolio" class="form-control"
                                                value="{{ is_null(old('portfolio')) ? $user->portfolio : old('portfolio') }}" />
                                            @if ($errors->has('portfolio'))
                                                <span class="help-block">{{ $errors->first('portfolio') }}</span>
                                            @endif
                                            @if ($user->portfolio)
                                                @if (str_contains($user->portfolio,'.pdf'))
                                                    <div class="img mt-2">
                                                        <embed src="{{ $user->portfolio }}" width="500" height="375">
                                                    </div>
                                                @elseif (str_contains($user->portfolio,'.jpg') || str_contains($user->portfolio,'.png')||str_contains($user->portfolio,'.jpeg'))
                                                    <div class="img mt-2">
                                                        <img class="img img-responsive" style="margin-bottom:5px;"
                                                            width="100" height="100" id="avatar" @if ($user->portfolio) src="{{ $user->portfolio }}" @endif>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('portfolio_link')) has-error @endif">
                                            <label for="nik-field">Link Portfolio</label>
                                            <input type="text" id="npwp-field" name="portfolio_link" class="form-control"
                                                value="{{ is_null(old('portfolio_link')) ? $user->portfolio_link : old('portfolio_link') }}" />
                                            @if ($errors->has('portfolio_link'))
                                                <span class="help-block">{{ $errors->first('portfolio_link') }}</span>
                                            @endif                                         
                                        </div>
                                        <div class="form-group @if ($errors->has('skill_set')) has-error @endif">
                                            <label for="triwulan-field">Skill Set</label>
                                            <select multiple class="form-control select2" id="skill_set-field"
                                                name="skill_set[]">
                                                @if ($user->extension->where('name', 'SKILLSET')->first())
                                                    @foreach ($masters->where('name', 'skill-set')->first()->value as $p)
                                                        <option @if (in_array($p['name'], $user->extension->where('name', 'SKILLSET')->first()->value)) selected @endif value="{{ $p['name'] }}">
                                                            {{ $p['name'] }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($masters->where('name', 'skill-set')->first()->value as $p)
                                                        <option value="{{ $p['name'] }}">
                                                            {{ $p['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('skill_set'))
                                                <span class="help-block">{{ $errors->first('skill_set') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('coverage-area') ? ' has-error' : '' }}">
                                            <label for="coverage-area">Coverage Area</label>
                                            <select multiple class="form-control select2" id="coverage-area-field" name="coverage[]">
                                                @if ($user->extension->where('name', 'Coverage')->first())
                                                    @foreach ($masters->where('name', 'area-coverage')->first()->value as $p)
                                                        @foreach ($p['child'] as $v)
                                                            <option value="{{ $v }}">{{ $v }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    @foreach ($masters->where('name', 'area-coverage')->first()->value as $p)
                                                        @foreach ($p['child'] as $v)
                                                            <option value="{{ $v }}">{{ $v }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('coverage-area'))
                                                <span class="help-block">{{ $errors->first('coverage-area') }}</span>
                                            @endif
                                        </div>
                                        <div
                                            class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation">Customer Segmentation</label>
                                            <select multiple class="form-control select2" id="segment-field"
                                                name="segment[]">
                                                @if ($user->extension->where('name', 'segment')->first())
                                                    @foreach ($masters->where('name', 'segment')->first()->value as $p)
                                                        <option @if (in_array($p['name'], $user->extension->where('name', 'segment')->first()->value)) selected @endif value="{{ $p['name'] }}">
                                                            {{ $p['name'] }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach ($masters->where('name', 'segment')->first()->value as $p)
                                                        <option value="{{ $p['name'] }}">
                                                            {{ $p['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if ($errors->has('customer_segmentation'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
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
@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                minimumInputLength: 2,
                allowClear: true
            });
        });
    </script>
@endsection
