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

                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <form action="{{ route('seting.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" id="seting" name="seting"
                                value="{{ $cms->name }}">
                            <input type="hidden" class="form-control" id="index" name="index" value="">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Kode</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="code" name="code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Link</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                    </div>
                                    <!-- /.form group -->
                                    <!-- /.box -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                    </div>
                    </form>
                    <!-- /.modal-dialog -->
                </div>
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
                                                placeholder="Masukkan nama seting" value="{{ $cms->name }}" readonly>
                                        </div>
                                    </div>

                                    <h3>List Setting
                                        <div style="float: right!important;">
                                            <button type="button" class="btn btn-sm btn-success open-status-dialog"
                                                data-toggle="modal" data-target="#modal-default"> <i
                                                    class="fa fa-plus"></i> Tambah
                                            </button>
                                        </div>
                                    </h3>


                                    <div class="card">
                                        <div class="card-body">
                                            <table id="tab-status" class="table display table-bordered table-stripped"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <td>No</td>
                                                        <th>Nama</th>
                                                        <th>Link</th>
                                                        <th>Preview</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cms['value'] as $key => $val)
                                                        <tr>
                                                            <td width="5%">{{ ++$key }}</td>
                                                            <td width="15%">{{ $val['text'] }}</td>
                                                            <td width="20%">{{ $val['image'] }}</td>
                                                            <td width="20%"> 
                                                                <img class="img img-fluid" src="{{ $val['image'] }}" alt="imge">
                                                            </td>
                                                            <td width="15%">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-warning open-status-dialog"
                                                                    data-index="{{ --$key }}"
                                                                    data-code="{{ $val['text'] }}"
                                                                    data-name="{{ $val['image'] }}"
                                                                    data-id="{{ $key }}" data-toggle="modal"
                                                                    data-target="#modal-default"> <i
                                                                        class="glyphicon glyphicon-edit"></i> Edit
                                                                </button>
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

            $('.open-status-dialog').on("click", function() {
                $('#code').val($(this).data('code'));
                $('#name').val($(this).data('name'));
                $('#index').val($(this).data('index'));
            });

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
