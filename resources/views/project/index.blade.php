@extends('layouts.app')
@section('title') Daftar project @endsection
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
                        <table class="table table-bordered table-striped" id="projectrange">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Order Number</th>
                                    <th>Room Number</th>
                                    <th>Customer Name</th>
                                    <th>Customer Contact</th>
                                    <th>Applicator Name</th>
                                    <th>Tipe Proyek</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Room ID</th>
                                    <th>Consultation ID</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $project->order_number }}</td>
                                        <td>{{ $project->room_number }}</td>
                                        <td>{{ $project->customer_name }}</td>
                                        <td>{{ $project->customer_contact }}</td>
                                        <td>{{ $project->vendor_name }}</td>
                                        <td width="10%">{{ $project->service_type }}</td>
                                        <td>{{ $project->status }}</td>
                                        <td>{{ $project->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $project->room_id }}</td>
                                        <td>{{ $project->consultation_id }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td width="15%">
                                            <a href="{{ route('proyek.edit', ['proyek' => $project->id]) }}"
                                                class="btn btn-sm btn-primary"> <i class="glyphicon glyphicon-edit"></i>
                                                Edit </a>
                                            <a href="{{ route('proyek.show', ['proyek' => $project->id]) }}"
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
            var dTable = $('#projectrange').dataTable({
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
