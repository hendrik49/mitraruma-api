@extends('layouts.app')
@section('title') Daftar Pengguna @endsection
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
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Quality</th>
                                    <th>Resp. to customer</th>
                                    <th>Resp. to Mitraruma</th>
                                    <th>Behavior</th>
                                    <th>Helpful</th>
                                    <th>Commitment</th>
                                    <th>Activeness</th>
                                    <th>OverAll Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aplikators as $key => $user)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $user->ID }}</td>
                                        <td>{{ $user->display_name }}</td>
                                        <td>{{ $user->review['quality']??'' }} </td>
                                        <td>{{ $user->review['responsiveness_to_customer']??'' }} </td>
                                        <td>{{ $user->review['responsiveness_to_mitraruma']??'' }} </td>
                                        <td>{{ $user->review['behaviour']??'' }} </td>
                                        <td>{{ $user->review['helpful']??'' }} </td>
                                        <td>{{ $user->review['commitment']??'' }} </td>
                                        <td>{{ $user->review['activeness']??'' }} </td>
                                        <td>{{ $user->review['overall_score']??'' }} </td>
                                        <td width="15%">
                                            <a href="{{ route('aplikators.edit', ['aplikator' => $user]) }}"
                                                class="btn btn-sm btn-warning"> <i class="glyphicon glyphicon-eye-open"></i>
                                                View </a>
                                        </td>
                                    </tr>
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
