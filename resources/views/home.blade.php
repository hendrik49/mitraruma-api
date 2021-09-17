@extends('layouts.app')
@section('title') Overview Data @endsection
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
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
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <!-- ./col -->
            @if(Auth::user()->user_type!="customer")
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>{{ $customer }}</h2>

                        <p>Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-person"></i>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->user_type!="vendor")
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>{{ $vendor }}</h2>

                        <p>Aplikator</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-person"></i>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>{{ $admin }}</h2>

                        <p>Admin</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-card"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h2>{{ $projects }} </h2>

                        <p>Jumlah Proyek</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-card"></i>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h2>Rp. {{$spk_customer}}</h2>
                        <p>Jumlah SPK Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h2>Rp. {{$spk_vendor}}</h2>

                        <p>Jumlah SPK Applicator</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cash"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>Rp. {{$project_value}}</h2>

                        <p>Nilai Proyek</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cash"></i>
                    </div>
                    <a href="admin/manage-Pembayaran-user" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h2>Rp. {{$total_expanse}}</h2>

                        <p>Total Pengeluaran</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cash"></i>
                    </div>
                    <a href="admin/manage-Pembayaran-user" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h2>Rp. {{$amount_spk_vendor_net}}</h2>

                        <p>Pembayaran Ke Aplikator</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-cash"></i>
                    </div>
                    <a href="admin/manage-Pembayaran-user" class="small-box-footer">More info <i
                            class="fa fa-arrow-circle-right"></i></a>
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
                            Metode Pembayaran
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart" style="height: 300px; width: 340px;" height="340" width="500"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div> --}}
            <div class="col-lg-6 col-xs-8">

                {{-- <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Goal Completion
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="progress-group">
                            Add Products to Cart
                            <span class="float-right"><b>160</b>/200</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 80%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                            Complete Purchase
                            <span class="float-right"><b>310</b>/400</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" style="width: 75%"></div>
                            </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Visit Premium Page</span>
                            <span class="float-right"><b>480</b>/800</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Send Inquiries
                            <span class="float-right"><b>250</b>/500</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Send Inquiries
                            <span class="float-right"><b>250</b>/500</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Send Inquiries
                            <span class="float-right"><b>250</b>/500</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->

                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Send Inquiries
                            <span class="float-right"><b>250</b>/500</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->

                    </div>
                    <!-- /.box-body -->
                </div> --}}
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
