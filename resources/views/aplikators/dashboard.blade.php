@extends('layouts.app')
@section('title') Overview Data @endsection
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-3 mt-4">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Filter
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group{{ $errors->has('service-type') ? ' has-error' : '' }}">
                            <label for="service-type">Service Type</label>
                            <select class="form-control" id="service-type-field" name="skill_set">
                                <option value="service">Home Service</option>
                                <option value="renovation">Home Renovation</option>
                            </select>
                            @if ($errors->has('service-type'))
                                <span class="help-block">{{ $errors->first('service-type') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('coverage-area') ? ' has-error' : '' }}">
                            <label for="coverage-area">Service Area</label>
                            <select class="form-control" id="coverage-area-field" name="skill_set">
                                {{-- @foreach ($masters->where('name', 'area-coverage')->first()->value as $p)
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endforeach --}}
                            </select>
                            @if ($errors->has('coverage-area'))
                                <span class="help-block">{{ $errors->first('coverage-area') }}</span>
                            @endif
                        </div>
                        <div class="form-group @if ($errors->has('skill_set')) has-error @endif">
                            <label for="triwulan-field">Skill Set</label>
                            <select class="form-control" id="skill_set-field" name="skill_set">
                                @foreach ($masters->where('name', 'skill-set')->first()->value as $p)
                                    <option value="{{ $p['code'] }}">{{ $p['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('skill_set'))
                                <span class="help-block">{{ $errors->first('skill_set') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('customer_segmentation') ? ' has-error' : '' }}">
                            <label for="customer_segmentation">Segmentation</label>
                            <select class="form-control" id="coverage-area-field" name="skill_set">
                                @foreach ($masters->where('name', 'segment')->first()->value as $p)
                                    <option value="{{ $p['code'] }}">{{ $p['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('customer_segmentation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('customer_segmentation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 mt-4">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Filter
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="userrange">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th>On Going</th>
                                    <th>% Capacity</th>
                                    <th>Overall Score</th>
                                    <th>Compitency</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aplikators as $key => $user)
                                    <tr>
                                        <td>{{ $user->vendor_user_id }}</td>
                                        <td>{{ $user->vendor_name }}</td>
                                        <td>{{ $user->review['quality'] }} </td>
                                        <td>{{ $user->review['responsiveness_to_customer'] }} </td>
                                        <td>{{ $user->review['responsiveness_to_mitraruma'] }} </td>
                                        <td>{{ $user->review['behaviour'] }} </td>
                                        <td>{{ $user->review['helpful'] }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- ./col -->
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Jenis Konsultasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart" style="height: 300px; width: 340px;" height="340" width="500"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Status Konsultasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartStatus" style="height: 300px; width: 340px;" height="340" width="500"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Progres Konsulltasi
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($progres as $val)
                            @if ($val->status == 'Project Ended')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>10</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            @if ($val->status == 'Project Started')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>8</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Construction Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>6</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 60%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Design Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>4</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 40%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'pre-purchase' || $val->status == 'Pre-Purchase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->order_number }} - {{ $val->description }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>2</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                        @endforeach
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Progres Aplikator
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach ($progresVendor as $val)
                            @if ($val->status == 'Project Ended')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>10</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            @if ($val->status == 'Project Started')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>8</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: 80%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Construction Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>6</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: 60%"></div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'Design Phase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>4</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 40%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                            <!-- /.progress-group -->
                            @if ($val->status == 'pre-purchase' || $val->status == 'Pre-Purchase')
                                <div class="progress-group">
                                    <a class="progress-text" href="{{ route('proyek.show', ['proyek' => $val->id]) }}">
                                        {{ $val->vendor_name }} - {{ $val->order_number }}
                                    </a>
                                    <p class="progress-text text-green text-sm"> {{ $val->status }} :
                                        {{ $val->project_note }}
                                    </p>
                                    <span class="float-right"><b>2</b>/10</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: 20%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            @endif
                        @endforeach
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>

        <div class="row">
            <!-- ./col -->
            {{-- <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Pembayaran Bulanan
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" style="height: 150px; width: 228px;" height="250" width="456"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div> --}}
        </div>

        <div class="row">
            <!-- ./col -->
            {{-- <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Pembayaran Bulanan (IDR)
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="barChartAmount" style="height: 150px; width: 228px;" height="250" width="456"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div> --}}

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
                    'scrollX': true
                });

                var config = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [
                                4,
                                6
                            ],
                            backgroundColor: [
                                "#F7464A",
                                "#46BFBD"
                            ],
                        }],
                        labels: [
                            "Home Service",
                            "Home Renovation"
                        ]
                    },
                    options: {
                        responsive: true
                    }
                };

                var configStatus = {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [
                                1,
                                2,
                                1,
                                3,
                                5
                            ],
                            backgroundColor: [
                                "#12464A",
                                "#4600BD",
                                "#07424A",
                                "#123655",
                                "#F73300"
                            ],
                        }],
                        labels: [
                            "Pre-Project",
                            "Design",
                            "Construction",
                            "Project Started",
                            "Project Ended"
                        ]
                    },
                    options: {
                        responsive: true
                    }
                };

                window.onload = function() {
                    var ctx = document.getElementById("pieChart").getContext("2d");
                    window.myPie = new Chart(ctx, config);

                    var ctxStatus = document.getElementById("pieChartStatus").getContext("2d");
                    window.myPieStatus = new Chart(ctxStatus, configStatus);

                };
            });
        </script>
    @endsection
