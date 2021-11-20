@extends('layouts.app')
@section('title') Daftar Seting @endsection
@section('content')
    <div class="row">
        <div class="container mt-2">
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
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered table-striped" id="userrange">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $key => $v)
                                    @if($v->name!=='area-coverage')
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td width="60%">{{ $v->name }}</td>
                                            <td width="20%">{{ $v->updated_at->format('Y-m-d') }}</td>
                                            <td width="15%">
                                                <a href="{{ route('seting.show', ['seting' => $v->id]) }}"
                                                    class="btn btn-sm btn-warning"> <i class="glyphicon glyphicon-eye-open"></i>
                                                    View </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
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
            var dTable = $('#userrange').dataTable({
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
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }, ]
            });
        });
    </script>
@endsection
