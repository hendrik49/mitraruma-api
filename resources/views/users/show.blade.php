@extends('layouts.app')

@section('title')Konsultasi {{$project->order_number }}
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
                        <h2 align="center" class="box-title">Konsultasi {{$project->order_number }}</h2>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('proyek.update', ['proyek' => $project]) }}" method="POST"
                                    class="shadow-sm p-3 bg-white" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">No. Konsultasi</label>
                                            <input type="text" class="form-control" name="order_number"
                                                placeholder="Masukkan no Konsultasi" value="{{ $project->order_number }}"
                                                readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">No. Room</label>
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
                                                placeholder="Masukkan nama donatur" readonly
                                                readonly>{{ $project->description }}</textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Alamat</label>
                                            <textarea rows="4" class="form-control" name="street" readonly
                                                placeholder="Masukkan alamat">{{ $project->street }}</textarea>
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
                                            <input type="date" class="form-control tgl" name="created_at"
                                                placeholder="Masukkan tanggal Konsultasi"
                                                value="{{ $project->created_at->format('yyyy-MM-dd') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="cover">Foto</label>
                                            @if ($project->images != '[]')
                                                <img src="{{ asset('storage/' . $project->images) }}" width="320px" />
                                            @endif
                                            <small class="text-muted">Format Image:png,jpg</small>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Status</label>
                                            <select class="form-control" id="status" name="status" readonly>
                                                <option value="verified" @if ($project->status == 'pre pruchase') selected='selected' @endif>Pre Purchase
                                                </option>
                                                <option value="pending" @if ($project->status == 'design phase') selected='selected' @endif>Design Phase
                                                </option>
                                                <option value="cancel" @if ($project->status == 'construction phase') selected='selected' @endif>Construction
                                                    Phase
                                                </option>
                                                <option value="expire" @if ($project->status == 'project started') selected='selected' @endif>Project
                                                    Started
                                                </option>
                                                <option value="success" @if ($project->status == 'project ended') selected='selected' @endif>Project Ended
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Amount SPK Customer Gross</label>
                                            <input type="number" class="form-control" name="amount_spk_customer_gross"
                                                placeholder="Masukkan amount SPK Customer Gross"
                                                value="{{ $project->amount_spk_customer_gross }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Mitraruma Diskon </label>
                                            <input type="number" class="form-control" name="mitraruma_discount"
                                                placeholder="Masukkan diskon" value="{{ $project->mitraruma_discount }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Applikator Diskon </label>
                                            <input type="number" class="form-control" name="applikator_discount"
                                                placeholder="Masukkan diskon" value="{{ $project->applikator_discount }}"
                                                readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Amount SPK Customer</label>
                                            <input type="number" class="form-control" name="amount_spk_customer"
                                                placeholder="Masukkan nilai spk customer"
                                                value="{{ $project->amount_spk_customer }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Biaya Material</label>
                                            <input type="number" class="form-control" name="material_buy"
                                                placeholder="Masukkan material buy" value="{{ $project->material_buy }}"
                                                readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Term Payment Customer</label>
                                            <textarea rows="4" class="form-control" name="term_payment_customer"
                                                placeholder="Masukkan term payment customer" readonly>{{ $project->term_payment_customer }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Total Expanse</label>
                                            <input type="number" class="form-control" name="total_expanse"
                                                placeholder="Masukkan total expanse"
                                                value="{{ $project->total_expanse }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Catatan Expanse</label>
                                            <textarea rows="4" class="form-control" name="expanse_note"
                                                placeholder="Masukkan expanse note" readonly>{{ $project->expanse_note }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Termin Customer 1</label>
                                            <input type="number" class="form-control" name="termin_customer_1"
                                                placeholder="termin customer 1"
                                                value="{{ $project->termin_customer_1 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Termin Customer 2</label>
                                            <input type="number" class="form-control" name="termin_customer_2"
                                                placeholder="termin customer 2"
                                                value="{{ $project->termin_customer_2 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Customer 1</label>
                                            <input type="date" class="form-control tgl" name="termin_customer_1_date"
                                                placeholder="termin customer 1"
                                                value="{{ $project->termin_customer_1 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Customer 2</label>
                                            <input type="date" class="form-control tgl" name="termin_customer_2_date"
                                                placeholder="termin customer 2"
                                                value="{{ $project->termin_customer_2 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Termin Customer 3</label>
                                            <input type="number" class="form-control" name="termin_customer_3"
                                                placeholder="termin customer 3"
                                                value="{{ $project->termin_customer_3 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Termin Customer 4</label>
                                            <input type="number" class="form-control" name="termin_customer_4"
                                                placeholder="termin customer 4"
                                                value="{{ $project->termin_customer_4 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Customer 3</label>
                                            <input type="date" class="form-control tgl" name="termin_customer_3_date"
                                                placeholder="termin customer 3"
                                                value="{{ $project->termin_customer_3 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Customer 4</label>
                                            <input type="date" class="form-control tgl" name="termin_customer_4_date"
                                                placeholder="termin customer 4"
                                                value="{{ $project->termin_customer_4 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Termin Customer 5</label>
                                            <input type="number" class="form-control" name="termin_customer_5"
                                                placeholder="termin customer 5"
                                                value="{{ $project->termin_customer_5 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Customer 5</label>
                                            <input type="date" class="form-control tgl" name="termin_customer_5_date"
                                                placeholder="termin customer 5"
                                                value="{{ $project->termin_customer_5 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Komisi</label>
                                            <input type="number" class="form-control" name="commision"
                                                placeholder="Masukkan komisi" value="{{ $project->commision }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Amount SPK Applikator</label>
                                            <input type="number" class="form-control" name="amount_spk_vendor"
                                                placeholder="Masukkan amount spk applicator"
                                                value="{{ $project->amount_spk_vendor }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Term Payment Applikator</label>
                                            <textarea rows="4" class="form-control" name="term_payment_vendor"
                                                placeholder="Masukkan term payment applikator" readonly>{{ $project->term_payment_vendor }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Termin Applikator 1</label>
                                            <input type="number" class="form-control" name="termin_vendor_1"
                                                placeholder="termin Applikator 1"
                                                value="{{ $project->termin_vendor_1 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Termin Applikator 2</label>
                                            <input type="number" class="form-control" name="termin_vendor_2"
                                                placeholder="termin Applikator 2"
                                                value="{{ $project->termin_vendor_2 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Applikator 1</label>
                                            <input type="date" class="form-control tgl" name="termin_vendor_1_date"
                                                placeholder="termin 1" value="{{ $project->termin_vendor_1_date }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Applikator 2</label>
                                            <input type="date" class="form-control tgl" name="termin_vendor_2_date"
                                                placeholder="termin 2" value="{{ $project->termin_vendor_2_date }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Termin Applikator 3</label>
                                            <input type="number" class="form-control" name="termin_vendor_3"
                                                placeholder="termin Applikator 3"
                                                value="{{ $project->termin_vendor_3 }}" readonly>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="title">Termin Applikator 4</label>
                                            <input type="number" class="form-control" name="termin_vendor_4"
                                                placeholder="termin Applikator 4"
                                                value="{{ $project->termin_vendor_4 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Applikator 3</label>
                                            <input type="date" class="form-control tgl" name="termin_vendor_3_date"
                                                placeholder="termin 3" value="{{ $project->termin_vendor_3_date }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Applikator 4</label>
                                            <input type="date" class="form-control tgl" name="termin_vendor_4_date"
                                                placeholder="termin 4" value="{{ $project->termin_vendor_4_date }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Termin Applikator 4</label>
                                            <input type="number" class="form-control" name="termin_vendor_4"
                                                placeholder="termin Applikator 4"
                                                value="{{ $project->termin_vendor_4 }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Termin Applikator 5</label>
                                            <input type="number" class="form-control" name="termin_vendor_5"
                                                placeholder="termin Applikator 5"
                                                value="{{ $project->termin_vendor_5 }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Applikator 4</label>
                                            <input type="date" class="form-control tgl" name="termin_vendor_4_date"
                                                placeholder="termin 4" value="{{ $project->termin_vendor_4_date }}" readonly>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Termin Applikator 5</label>
                                            <input type="date" class="form-control tgl" name="termin_vendor_5_date"
                                                placeholder="termin 5" value="{{ $project->termin_vendor_5_date }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tanggal Retensi</label>
                                            <input type="date" class="form-control tgl" name="payment_retention_date"
                                                placeholder="termin 5" value="{{ $project->payment_retention_date }}" readonly>
                                        </div>
                                    </div>

                                    <a href="/admin/proyek" class="btn btn-primary btn-flat mb-2"
                                        name="save_action">Kembali</a>
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