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
                                    <th>ID Mitraruma</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>NIK</th>
                                    <th>NPWP</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $user->ID }}</td>
                                        <td width="10%">{{ $user->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $user->display_name }}</td>
                                        <td>{{ $user->user_email }}</td>
                                        <td>{{ $user->user_phone_number }}</td>
                                        <td>{{ $user->nik }}</td>
                                        <td>{{ $user->npwp }}</td>
                                        <td>{{ $user->user_type }}</td>
                                        <td>{{ $user->user_status ? 'Verified' : 'Unverified' }}</td>
                                        <td width="15%">
                                            <a href="{{ route('users.show', ['user' => $user]) }}"
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                }, ]
            });
        });
    </script>
@endsection
