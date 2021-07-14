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
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>10</h2>

                        <p>Jumlah Pelanggan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-person"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>20</h2>

                        <p>Jumlah Applicator</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-person"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h2>30</h2>

                        <p>Jumlah Admin</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-card"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h2>20 </h2>

                        <p>Jumlah Proyek</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-card"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h2>200</h2>
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
                        <h2>400</h2>

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
                        <h2>Rp. 500000</h2>

                        <p>Pembayaran Pending</p>
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
                        <h2>Rp. 40000</h2>

                        <p>Pembayaran Kadaluarsa</p>
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
                        <h2>Rp. 150000</h2>

                        <p>Pembayaran Terkirim</p>
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
            </div>
            <div class="col-lg-6 col-xs-8">
                <div class="card ">
                    <div class="card-header ui-sortable-handle">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Jenis Pembayaran
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChartPembayaran" style="height: 300px; width: 340px;" height="340" width="500"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

        <div class="row">
            <!-- ./col -->
            <div class="col-md-12">
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
            </div>
        </div>

        <div class="row">
            <!-- ./col -->
            <div class="col-md-12">
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
            </div>

        </div>
    @endsection
