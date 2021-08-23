@extends('layouts.app')

@section('title')Konsultasi
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
                        <h2 align="center" class="box-title">Konsultasi</h2>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">No Konsultasi</label>
                                        <input type="text" class="form-control" name="order_number"
                                            placeholder="Masukkan no Konsultasi" value="{{ $project->order_number }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">No Room</label>
                                        <input type="text" class="form-control" name="room_id"
                                            placeholder="Masukkan no room" value="{{ $project->room_id }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Nama Customer</label>
                                        <input type="text" class="form-control" name="customer_name"
                                            placeholder="Masukkan nama customer" value="{{ $project->customer_name }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Kontak Customer</label>
                                        <input type="text" class="form-control" name="customer_name"
                                            placeholder="Masukkan kontak customer"
                                            value="{{ $project->customer_contact }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Nama Applikator </label>
                                        <input type="email" class="form-control" name="vendor_name"
                                            placeholder="Masukkan nama applikator" value="{{ $project->vendor_name }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Kontak Applikator</label>
                                        <input type="text" class="form-control" name="vendor_contact"
                                            placeholder="Masukkan kontak applikator"
                                            value="{{ $project->vendor_contact }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Konsultasi</label>
                                        <textarea rows="4" class="form-control" name="description"
                                            placeholder="Masukkan nama donatur"
                                            readonly>{{ $project->description }}</textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Alamat</label>
                                        <textarea rows="4" class="form-control" name="street" placeholder="Masukkan alamat"
                                            readonly>{{ $project->street }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Estimasi Budget Konsultasi (Rp)</label>
                                        <input type="number" min="1" class="form-control" name="estimated_budget"
                                            placeholder="Masukkan budget" onkeypress="return isNumberKey(event)"
                                            value="{{ $project->estimated_budget }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Tgl Konsultasi</label>
                                        <input type="date" class="form-control" id="tgl_Konsultasi" name="created_at"
                                            placeholder="Masukkan tanggal Konsultasi"
                                            value="{{ $project->created_at->format('yyyy-MM-dd') }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="cover">Foto</label>
                                        @if ($project->images != '[]')
                                            <img src="{{ asset('storage/' . $project->images) }}" width="320px" />
                                        @else
                                            <small class="text-muted">No Images</small>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Status</label>
                                        <select class="form-control" id="status" name="status" disabled>
                                            <option value="verified" @if ($project->status == 'verified') selected='selected' @endif>Pre Purchase
                                            </option>
                                            <option value="pending" @if ($project->status == 'pending') selected='selected' @endif>Design Phase
                                            </option>
                                            <option value="cancel" @if ($project->status == 'cancel') selected='selected' @endif>Construction Phase
                                            </option>
                                            <option value="expire" @if ($project->status == 'expire') selected='selected' @endif>Project Started
                                            </option>
                                            <option value="success" @if ($project->status == 'success') selected='selected' @endif>Project Ended
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Amount SPK Customer Gross</label>
                                        <input type="number" class="form-control" name="amount_spk_customer_gross"
                                            placeholder="Masukkan no Konsultasi"
                                            value="{{ $project->amount_spk_customer_gross }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Amount SPK Customer</label>
                                        <input type="number" class="form-control" name="amount_spk_customer"
                                            placeholder="Masukkan no Konsultasi"
                                            value="{{ $project->amount_spk_customer }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Diskon </label>
                                        <input type="number" class="form-control" name="discount"
                                            placeholder="Masukkan diskon" value="{{ $project->discount }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Komisi</label>
                                        <input type="number" class="form-control" name="commision"
                                            placeholder="Masukkan komisi" value="{{ $project->commision }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Termin Customer 1</label>
                                        <input type="number" class="form-control" name="termin_customer_1"
                                            placeholder="termin customer 1" value="{{ $project->termin_customer_1 }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Termin Customer 2</label>
                                        <input type="number" class="form-control" name="termin_customer_2"
                                            placeholder="termin customer 2" value="{{ $project->termin_customer_2 }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Termin Customer 3</label>
                                        <input type="number" class="form-control" name="termin_customer_3"
                                            placeholder="termin customer 3" value="{{ $project->termin_customer_3 }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Termin Customer 4</label>
                                        <input type="number" class="form-control" name="termin_customer_4"
                                            placeholder="termin customer 4" value="{{ $project->termin_customer_4 }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Termin Customer 5</label>
                                        <input type="number" class="form-control" name="termin_customer_5"
                                            placeholder="termin customer 5" value="{{ $project->termin_customer_5 }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Amount SPK Applikator</label>
                                        <input type="number" class="form-control" name="amount_spk_vendor"
                                            placeholder="Masukkan amount spk applicator"
                                            value="{{ $project->amount_spk_vendor }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Termin Appliaktor 1</label>
                                        <input type="number" class="form-control" name="termin_vendor_1"
                                            placeholder="termin Applikator 1" value="{{ $project->termin_vendor_1 }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Termin Appliaktor 2</label>
                                        <input type="number" class="form-control" name="termin_vendor_2"
                                            placeholder="termin Applikator 2" value="{{ $project->termin_vendor_2 }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Termin Appliaktor 3</label>
                                        <input type="number" class="form-control" name="termin_vendor_3"
                                            placeholder="termin Applikator 3" value="{{ $project->termin_vendor_3 }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="title">Termin Appliaktor 4</label>
                                        <input type="number" class="form-control" name="termin_vendor_4"
                                            placeholder="termin Applikator 4" value="{{ $project->termin_vendor_4 }}"
                                            readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="title">Termin Appliaktor 5</label>
                                        <input type="number" class="form-control" name="termin_vendor_5"
                                            placeholder="termin Applikator 5" value="{{ $project->termin_vendor_5 }}"
                                            readonly>
                                    </div>
                                </div>
                                <a href="/admin/proyek" class="btn btn-primary btn-flat mb-2" name="save_action">Kembali</a>
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