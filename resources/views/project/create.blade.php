@extends('layouts.app')

@section('title')Tambah Konsultasi
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
                    <div class="box-header with-border">
                        <h2 align="center" class="box-title">Tambah Konsultasi</h2>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('proyek.store') }}" method="POST" class="shadow-sm p-3 bg-white"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">No Konsultasi</label>
                                            <input type="text" class="form-control" name="order_number"
                                                placeholder="Masukkan no Konsultasi"
                                                value="{{ mt_rand(1000000, 9999999) }}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">No Room</label>
                                            <input type="text" class="form-control" name="room_id"
                                                placeholder="Masukkan no room" value="{{ mt_rand(1000000, 9999999) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Nama Customer</label>
                                            <select class="form-control" id="user_id" name="user_id" required>
                                                @foreach ($customers as $key => $val)
                                                    <option value="{{ $val->ID }}"
                                                        value-name="{{ $val->display_name }}">{{ $val->display_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Kontak Customer</label>
                                            <input type="text" class="form-control" name="customer_contact"
                                                placeholder="Masukkan kontak customer"
                                                value="{{ old('customer_contact') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Nama Applikator </label>
                                            <select class="form-control" id="vendor_user_id" name="vendor_user_id"
                                                required>
                                                @foreach ($aplikators as $key => $val)
                                                    <option value="{{ $val->ID }}">{{ $val->display_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Kontak Applikator</label>
                                            <input type="text" class="form-control" name="vendor_contact"
                                                placeholder="Masukkan kontak applikator"
                                                value="{{ old('vendor_contact') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Konsultasi</label>
                                            <textarea rows="4" class="form-control" name="description"
                                                placeholder="Masukkan nama donatur"
                                                required>{{ old('description') }}</textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Alamat</label>
                                            <textarea rows="4" class="form-control" name="street"
                                                placeholder="Masukkan alamat" required>{{ old('street') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Estimasi Budget Konsultasi (Rp)</label>
                                            <input type="number" min="1" class="form-control" name="estimated_budget"
                                                placeholder="Masukkan budget" onkeypress="return isNumberKey(event)"
                                                value="{{ old('estimated_budget') }}" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tgl Konsultasi</label>
                                            <input type="date" class="form-control" id="tgl_Konsultasi" name="created_at"
                                                placeholder="Masukkan tanggal Konsultasi" value="{{ old('created_at') }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="cover">Foto</label>
                                            <input type="file" class="form-control" name="dokumentasi" accept="image/*">
                                            <small class="text-muted">Format Image:png,jpg</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="pre purchase">Pre-Purchase
                                                </option>
                                                <option value="design phase">Design Phase
                                                </option>
                                                <option value="construction phase">Construction Phase
                                                </option>
                                                <option value="project started">Project Started
                                                </option>
                                                <option value="project ended">Project Ended</option>
                                                <option value="delay">Delay</option>
                                                <option value="complaint">Complaint</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tipe Service</label>
                                            <select class="form-control" id="service_type" name="service_type" required>
                                                <option value="SERVICE">Home Service</option>
                                                <option value="RENOVATION">Home Renovation</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Sub Status</label>
                                            <select class="form-control" id="sub_status" name="sub_status" required>
                                                @foreach ($subStatus as $key => $val)
                                                    <option value="{{ $key }}">{{ $val->activity }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-flat" name="save_action"
                                        value="PUBLISH">Publish</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("tgl_Konsultasi").valueAsDate = new Date();
    </script>
@stop
