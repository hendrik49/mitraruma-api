@extends('layouts.app')

@section('title')Pengguna
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
                                <form action="#" enctype="multipart/form-data" method="POST">
                                    <div class="form-group @if ($errors->has('user_picture_url')) has-error @endif">
                                        <div class="img">
                                            <img class="img-circle" style="margin-bottom:5px;" width="100" height="100"
                                                id="avatar" @if ($user->user_picture_url) src="{{ $user->user_picture_url }}" @else src="http://nanoup.net/assets/userdata/avatar/thumbs/default-avatar.png" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('display_name')) has-error @endif">
                                        <label for="name-field">Nama</label>
                                        <input type="text" id="name-field" name="display_name" class="form-control"
                                            value="{{ is_null(old('display_name')) ? $user->display_name : old('display_name') }}"
                                            readonly />
                                    </div>
                                    <div class="form-group @if ($errors->has('user_type')) has-error @endif">
                                        <label for="name-field">Role</label>
                                        <input type="text" id="name-field" name="user_type" class="form-control"
                                            value="{{ is_null(old('user_type')) ? $user->user_type : old('user_type') }}"
                                            readonly />
                                    </div>
                                    <div class="form-group @if ($errors->has('nik')) has-error @endif">
                                        <label for="nik-field">NIK KTP</label>
                                        <input type="text" id="nik-field" name="nik" class="form-control"
                                            value="{{ is_null(old('nik')) ? $user->nik : old('nik') }}" readonly />
                                    </div>
                                    <div class="form-group @if ($errors->has('file_nik')) has-error @endif">
                                        <label for="nik-field">File KTP</label>
                                        @if ($user->file_nik)
                                            <div class="img mt-2">
                                                <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                    height="100" id="avatar" @if ($user->file_nik) src="{{ $user->file_nik }}" @endif>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group @if ($errors->has('npwp')) has-error @endif">
                                        <label for="npwp-field">No. NPWP</label>
                                        <input type="text" id="npwp-field" name="npwp" class="form-control"
                                            value="{{ is_null(old('npwp')) ? $user->npwp : old('npwp') }}" readonly />
                                    </div>
                                    <div class="form-group @if ($errors->has('file_npwp')) has-error @endif">
                                        <label for="nik-field">File NPWP</label>
                                        @if ($user->file_npwp)
                                            <div class="img mt-2">
                                                <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                    height="100" id="avatar" @if ($user->file_npwp) src="{{ $user->file_npwp }}" @endif>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group @if ($errors->has('user_email')) has-error @endif">
                                        <label for="user_email-field">Email</label>
                                        <input type="text" id="user_email-field" name="user_email" class="form-control"
                                            value="{{ is_null(old('user_email')) ? $user->user_email : old('user_email') }}"
                                            readonly />
                                    </div>
                                    <div class="form-group @if ($errors->has('user_phone_number')) has-error @endif">
                                        <label for="user_phone_number-field">Nomor kontak</label>
                                        <input type="text" id="user_phone_number-field" name='user_phone_number'
                                            class="form-control"
                                            value="{{ is_null(old('user_phone_number')) ? $user->user_phone_number : old('user_phone_number') }}"
                                            readonly />
                                    </div>
                                    @if ($user->user_type == 'vendor')
                                        <div class="form-group @if ($errors->has('capacity')) has-error @endif">
                                            <label for="name-field">Kapasitas</label>
                                            <input type="text" id="name-field" name="capacity" class="form-control"
                                                value="{{ is_null(old('capacity')) ? $user->capacity : old('capacity') }}"
                                                readonly />
                                            @if ($errors->has('capacitye'))
                                                <span class="help-block">{{ $errors->first('capacity') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('bank')) has-error @endif">
                                            <label for="name-field">Bank</label>
                                            <input type="text" id="name-field" name="bank" class="form-control"
                                                value="{{ is_null(old('bank')) ? $user->bank : old('bank') }}"
                                                readonly />
                                        </div>
                                        <div class="form-group @if ($errors->has('bank_account')) has-error @endif">
                                            <label for="bank_account-field">No. Rekening</label>
                                            <input type="text" id="bank_account-field" name="bank_account"
                                                class="form-control"
                                                value="{{ is_null(old('bank_account')) ? $user->bank_account : old('bank_account') }}"
                                                readonly />
                                        </div>
                                        <div class="form-group @if ($errors->has('file_bank')) has-error @endif">
                                            <label for="nik-field">File Tabungan</label>
                                            @if ($user->file_bank)
                                                <div class="img mt-2">
                                                    <img class="img img-responsive" style="margin-bottom:5px;" width="100"
                                                        height="100" id="avatar" @if ($user->file_bank) src="{{ $user->file_bank }}" @endif>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('portfolio')) has-error @endif">
                                            <label for="nik-field">Portfolio</label>
                                            @if ($user->portfolio)
                                                @if (true)
                                                    <div class="img mt-2">
                                                        <embed src="{{ $user->portfolio }}" width="500" height="375">
                                                    </div>
                                                @else
                                                    <div class="img mt-2">
                                                        <img class="img img-responsive" style="margin-bottom:5px;"
                                                            width="100" height="100" id="avatar" @if ($user->portfolio) src="{{ $user->portfolio }}" @endif>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="form-group @if ($errors->has('skill_set')) has-error @endif">
                                            <label for="triwulan-field">Skill Set </label>
                                            <select multiple class="form-control select2" id="skill_set-field" name="skill_set">
                                                @if ($user->extension->where('name', 'SKILLSET')->first())
                                                    @foreach ($masters->where('name', 'skill-set')->first()->value as $p)
                                                        <option @if (in_array($p['name'], $user->extension->where('name', 'SKILLSET')->first()->value)) selected @endif value="{{ $p['code'] }}">
                                                            {{ $p['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group{{ $errors->has('coverage-area') ? ' has-error' : '' }}">
                                            <label for="coverage-area">Coverage Area</label>
                                            <select class="form-control" id="coverage-area-field" name="skill_set">
                                                @if ($user->extension->where('name', 'Coverage')->first())
                                                    @foreach ($user->extension->where('name', 'Coverage')->first()->value as $p)
                                                        <option value="{{ $p }}">{{ $p }}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                        <div
                                            class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                                            <label for="customer_segmentation">Customer Segmentation </label>
                                            <select class="form-control select2" multiple id="coverage-area-field"
                                                name="skill_set">
                                                @if ($user->extension->where('name', 'segment')->first())
                                                    @foreach ($masters->where('name', 'segment')->first()->value as $p)
                                                        <option @if (in_array($p['name'], $user->extension->where('name', 'segment')->first()->value)) selected @endif value="{{ $p['code'] }}">
                                                            {{ $p['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    @endif
                                    <div class="well well-sm mb-2">
                                        <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-primary">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                            Edit </a>
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
            $('.select2').select2();
        });
    </script>
@endsection
