@extends('layouts.app')

@section('title')Konsultasi {{ $project->order_number }}
@endsection

@section('content')

    <div class="row">
        <div class="container col-sm-12">
            <div class="col-md-12">
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
                        <h2 align="center" class="box-title">Konsultasi {{ $project->order_number }}</h2>
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
                                                placeholder="Masukkan nama applikator"
                                                value="{{ $project->vendor_name }}" readonly>
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
                                            <input type="text" class="form-control tgl" name="created_at"
                                                placeholder="Masukkan tanggal Konsultasi"
                                                value="{{ $project->created_at->format('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
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
                                        <div class="col-sm-6">
                                            <label for="title">Room ID</label>
                                            <input type="text" class="form-control" name="room_id"
                                                placeholder="Masukkan no room" value="{{ $project->room_id }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-11">
                                            <label for="cover">Foto</label>
                                            <br>
                                            @if ($project->images != null)
                                                <div id="carouselExampleControls" class="carousel slide"
                                                    data-ride="carousel">
                                                    <ol class="carousel-indicators">
                                                        @foreach (json_decode($project->images) as $key => $image)
                                                            <li data-target="#carouselExampleIndicators"
                                                                data-slide-to="{{ $key }}"
                                                                class="{{ $key == 0 ? 'active' : '' }}"></li>
                                                        @endforeach
                                                    </ol>
                                                    <div class="carousel-inner" role="listbox">
                                                        @foreach (json_decode($project->images) as $key => $image)
                                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                @if (isset($image->pathUrl))
                                                                    <img class="d-block img-fluid"
                                                                        src="{{ $image->pathUrl }}" width="320px"
                                                                        alt="imge">
                                                                @else
                                                                    <img class="d-block img-fluid"
                                                                        src="{{ asset('storage/' . $image) }}"
                                                                        width="320px" alt="imge">
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleControls"
                                                        role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleControls"
                                                        role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <h3>List Order Status </h3>

                                    <div class="card">
                                        <div class="card-body">
                                            <table id="tab-status" class="table display table-bordered table-stripped"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <td>No</td>
                                                        <th>Status</th>
                                                        <th>Sub Status</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (isset($status['data']) ? $status['data'] : $status as $key => $val)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td width="15%"">{{ $val['phase'] }}</td>
                                                                            <td width=" 30%">
                                                                <ul>
                                                                    @if (isset($val['list']))
                                                                        @foreach ($val['list'] as $key => $item)
                                                                            <li>{{ $item['activity'] }}</li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </td>
                                                            <td width="5%">
                                                                <ul>
                                                                    @if (isset($val['list']))
                                                                        @foreach ($val['list'] as $key => $item)
                                                                            @if (isset($item['type']))
                                                                                <li>{{ $item['type'] }}</li>
                                                                            @else
                                                                                <li>general</li>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </td>
                                                            <td width="15%">
                                                                <ul>
                                                                    @if (isset($val['list']))
                                                                        @foreach ($val['list'] as $key => $item)
                                                                            <li>{{ date('Y-m-d', strtotime($item['createdAt'])) }}
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <ul>
                                                                    @if (isset($val['list']))
                                                                        @foreach ($val['list'] as $key => $item)
                                                                            @if (isset($item['file']) && isset($item['file'][0]))
                                                                                <li><a target="_blank"
                                                                                        href={{ $item['file'] }}>click to
                                                                                        view {{ $item['activity'] }}</a>
                                                                                </li>
                                                                            @elseif (isset($item['attachment']))
                                                                                <li><i class="fas fa-file"></i> <a
                                                                                        target="_blank"
                                                                                        href={{ $item['attachment'][0] }}>click
                                                                                        to view
                                                                                        {{ $item['activity'] }}</a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
@section('scripts')
    @parent
    <script type="text/javascript">
        $(function() {
            var dTable = $('#tab-status').dataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'responsive': true,
                'info': true,
                'scrollX': true,
                'dom': 'Bfrtip',
                'buttons': [{
                    extend: 'excel',
                    // exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5]
                    // }
                }, ]
            });
        });
    </script>
@endsection
@stop
