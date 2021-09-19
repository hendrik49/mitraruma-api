@extends('layouts.app')

@section('title')Seting {{ $cms->id }}
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
                        <h2 align="center" class="box-title">Seting {{ $cms->name }}</h2>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('seting.update', ['seting' => $cms]) }}" method="POST"
                                    class="shadow-sm p-3 bg-white" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label for="title">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Masukkan nama seting" value="{{ $cms->name }}"
                                                readonly>
                                        </div>
                                    </div>                                    
                             
                                    <h3>List Setting</h3>

                                    <div class="card">
                                        <div class="card-body">
                                            <table id="tab-status" class="table display table-bordered table-stripped"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <td>No</td>
                                                        <th>Nama</th>
                                                        <th>Link</th>
                                                        <th>Ikon</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ( $cms['value'] as $key => $val)
                                                        <tr>
                                                            <td width="5%">{{ ++$key }}</td>
                                                            <td width="15%">{{ $val['name'] }}</td>
                                                            <td width="45%">{{ $val['link'] }}</td>   
                                                            <td width="45%">{{ $val['icon'] }}</td>   
                                                            <td width="15%">
                                                                <a href="{{ route('seting.show', ['seting' => $cms->id]) }}"
                                                                    class="btn btn-sm btn-warning"> <i class="glyphicon glyphicon-eye-open"></i>
                                                                    Edit </a>
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
