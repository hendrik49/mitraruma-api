@extends('layouts.app')
@section('title') Daftar project @endsection
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
                <div class="mt-2">
                    <div class="form-group">
                        From: <input type="date" name="date_start" id="date_start" class="datepicker" />
                        To: <input type="date" name="date_end" id="date_end" class="datepicker" />
                    </div>
                </div>
                <div class="box" style="margin-top: 0px;">
                    <div class="box-body">
                        <table class="table display table-bordered table-striped" id="projectrange" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Order Number</th>
                                    <th>Room Number</th>
                                    <th>Customer Name</th>
                                    <th>Applicator Name</th>
                                    <th>Consulation</th>
                                    <th>Est. Budget</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $project)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $project->order_number }}</td>
                                        <td>{{ $project->room_id }}</td>
                                        <td>{{ $project->customer_name }}</td>
                                        <td>{{ $project->vendor_name }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td class="text-right">{{ $project->estimated_budget }}</td>
                                        <td>{{ $project->status }}</td>
                                        <td>{{ $project->created_at->format('Y-m-d') }}</td>
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
            vStartDate = "{{ $start_date }}";
            vEndDate = "{{ $end_date }}";
            document.getElementById("date_start").valueAsDate = vStartDate ? new Date(vStartDate) : new Date();
            document.getElementById("date_end").valueAsDate = vEndDate ? new Date(vEndDate) : new Date();

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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                    }
                }, ]
            });

            $("#date_start").keyup(function() {
                searchByDate();
            });
            $("#date_start").change(function() {
                searchByDate();
            });
            $("#date_end").keyup(function() {
                searchByDate();
            });
            $("#date_end").change(function() {
                searchByDate();
            });

            function searchByDate() {
                var dateStart = $('#date_start').val();
                var dateEnd = $('#date_end').val();
                var url = 'project?date_start=' + dateStart + '&date_end=' + dateEnd;
                window.open(url, "_self")
            }
        });
    </script>
@endsection
