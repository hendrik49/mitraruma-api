@extends('layouts.app')

@section('title')Edit Konsultasi
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
                        <h2 align="center" class="box-title">Edit Konsultasi</h2>
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
                                                placeholder="Masukkan no room" value="{{ $project->room_number }}"
                                                readonly>
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
                                                required>{{ $project->description }}</textarea>
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
                                            <input type="date" class="form-control" id="tgl_Konsultasi" name="created_at"
                                                placeholder="Masukkan tanggal Konsultasi"
                                                value="{{ $project->created_at->format('d/m/Y') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Status</label>
                                            <select class="form-control" id="status" name="status" readonly>
                                                <option value="pre purchase" @if ($project->status == 'pre pruchase') selected='selected' @endif>Pre Purchase
                                                </option>
                                                <option value="design phase" @if ($project->status == 'design phase') selected='selected' @endif>Design Phase
                                                </option>
                                                <option value="construction phase" @if ($project->status == 'construction phase') selected='selected' @endif>Construction
                                                    Phase
                                                </option>
                                                <option value="project started" @if ($project->status == 'project started') selected='selected' @endif>Project
                                                    Started
                                                </option>
                                                <option value="project ended" @if ($project->status == 'project ended') selected='selected' @endif>Project Ended
                                                </option>
                                                <option value="delay" @if ($project->status == 'delay') selected='selected' @endif>Delay</option>
                                                <option value="complaint" @if ($project->status == 'complaint') selected='selected' @endif>Complaint</option>
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
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Tipe Service</label>
                                            <select class="form-control" id="service_type" name="service_type" required>
                                                <option value="SERVICE" @if ($project->service_type = 'SERVICE') selected @endif>Home Service</option>
                                                <option value="RENOVATION" @if ($project->service_type = 'RENOVATION') selected @endif>Home Renovation</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="cover">Foto</label>
                                            @if ($project->images != null)
                                                @foreach (json_decode($project->images) as $image)
                                                    <div class="col-sm-6">
                                                        <img src="{{ $image->pathUrl }}" width="320px" />
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" value="PUT" name="_method">
                                    <button class="btn btn-primary btn-flat" name="save_action"
                                        value="PUBLISH">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementsByClassName("tgl").valueAsDate = new Date();
    </script>
@stop
