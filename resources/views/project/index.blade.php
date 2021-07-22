@extends('layouts.global')
@section('title') Daftar Donasi @endsection
@section('content')
<div class="row">
	<div class="container col-sm-12">
		<div class="col-md-12">
			@if(session('status'))
			<div class="alert alert-success">
				{{session('status')}}
			</div>
			@elseif(session('gagal'))
			<div class="alert alert-danger">
				{{session('gagal')}}
			</div>
			@endif
			@php
			$no = 1;
			@endphp
			
			<h2>List Donasi Donatur</h2>
			{{-- <div class="col-md-12 btn-selection">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="btn-primary {{Request::get('status') == NULL &&
			Request::path() == 'admin/manage-donasi-user' ? 'active' : ''}}" href="
			{{route('manage-donasi-user.index')}}">All Post</a>
					</li>
					<li class="nav-item">
						<a class="btn-primary {{Request::get('status') == 'sampai' ?
			'active' : '' }}" href="{{route('manage-donasi-user.index', ['status' =>
			'sampai'])}}">Terkirim</a>
					</li>
					<li class="nav-item">
						<a class="btn-primary {{Request::get('status') == 'belum' ?
			'active' : '' }}" href="{{route('manage-donasi-user.index', ['status' =>
			'belum'])}}">Belum Sampai</a>
					</li>
					<li class="nav-item">
						<a class="btn-primary {{Request::get('status') == 'manual' ?
			'active' : '' }}" href="{{route('manage-donasi-user.index', ['status' =>
			'manual'])}}">Manual</a>
					</li>
				</ul>
			</div> --}}

			<div class="form-group">
				From: <input type="date" name="date_start" id="date_start" class="datepicker" />
				To: <input type="date" name="date_end" id="date_end" class="datepicker"/>
			</div>			
			@if(Request::get('status') == NULL && Request::path() == 'admin/manage-donasi-user')
			<div class="box" style="margin-top: 0px;">
				<div class="box-body">
					<table class="table display table-bordered table-striped" id="donasirange" style="width: 100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>Invoice</th>
								<th>Status</th>
								<th>Program</th>
								<th>Tanggal</th>
								<th>Email/No HP</th>
								<th>Metode Bayar</th>
								<th>Jenis Bayar</th>
								<th>Jumlah Donasi</th>
								<th>Nama Pengirim</th>
								<th>Anggota</th>
								<th>Ref</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($donasi as $donasis)
							<tr>
								<td></td>
								<td>{{$donasis->invoice}}</td>
								<td>
									@if($donasis->status=="settlement" ||  $donasis->status=="success")
									<span class="label label-success" style="font-size: 13px;"><i class="fa fa-check-circle-o"> {{ $donasis->status}}</i></span>
									@elseif($donasis->status == 'verified')
									<span class="label label-success" style="font-size: 13px;"><i class="fa fa-check"> {{ $donasis->status}}</i> </span>
									@elseif($donasis->status == 'pending')
									<span class="label label-warning" style="font-size: 13px;"><i class="fa fa-spinner"> {{ $donasis->status}}</i> </span>
									@else
									<span class="label label-danger" style="font-size: 13px;"><i class="fa fa-spinner"> {{ $donasis->status}}</i> </span>
									@endif
								</td>
								<td>{{$donasis->prokers?$donasis->prokers['nama_kegiatan']:$donasis->url}}</td>
								<td>{{$donasis->created_at->format('Y-m-d')}}</td>
								<td>{{$donasis->email?$donasis->email:$donasis->nohp}}</td>
								<td>{{$donasis->type}}</td>
								<td>{{$donasis->bank_reff_id}}</td>
								<td class="text-right">Rp. {{format_uang($donasis->jumlah)}}</td>
								<td>{{$donasis->nama}}</td>								
								<td>{{$donasis->message}}</td>								
								<td class="text-right">{{ $donasis->ref }}</td>								
								<td>
									@if(Auth::user()->role_id==1)
									<form action="{{ route('manage-donasi-user.destroy', ['id' => $donasis->id]) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete donasi no {{ $donasis->invoice }} ? Are you sure?')) { return true } else {return false };">
										<input type="hidden" name="_method" value="DELETE">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
									</form>
									@endif
								</td>
							</tr>
							@endforeach

						</tbody>			
					</table>
				</div>
			</div>
			@elseif(Request::get('status') == 'sampai')

			<div class="box" style="margin-top: 60px;">
				<div class="box-body">
					<table class="table table-bordered table-striped donasiuser" style="width: 100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>Invoice</th>
								<th>Nama Pengirim</th>
								<th>Tanggal</th>
								<th>Email</th>
								<th>Jumlah Donasi</th>
								<th>Nama Program</th>
								<th>Metode Bayar</th>
								<th>Status</th>
							</tr>
						</thead>

						<tbody>

							@foreach($donasi as $donasis)
							<tr>
								<td></td>
								<td>{{$donasis->invoice}}</td>
								<td>{{$donasis->nama}}</td>
								<td>{{$donasis->created_at}}</td>
								<td>{{$donasis->email}}</td>
								<td>Rp. {{format_uang($donasis->jumlah)}}</td>
								<td>{{$donasis->url}}</td>
								<td>{{$donasis->type}}</td>
								<td><span class="label label-success" style="font-size: 13px;"><i class="fa fa-check-circle-o"> Terbayar</i></span></td>
							</tr>
							@endforeach

						</tbody>
					</table>
				</div>
			</div>
			@elseif(Request::get('status') == 'belum')
			<div class="box" style="margin-top: 60px;">
				<div class="box-body">
					<table class="table table-bordered table-striped donasiuser" style="width: 100%">
						<thead>
							<tr>
								<th>No.</th>
								<th>Invoice</th>
								<th>Nama Pengirim</th>
								<th>Nama Program</th>
								<th>Tanggal</th>
								<th>Email</th>
								<th>Jumlah Donasi</th>
								<th>Metode Bayar</th>
								<th>Status</th>
							</tr>
						</thead>

						<tbody>

							@foreach($donasi as $donasis)
							<tr>
								<td></td>
								<td>{{$donasis->invoice}}</td>
								<td>{{$donasis->nama}}</td>
								<td>{{$donasis->url}}</td>
								<td>{{$donasis->created_at}}</td>
								<td>{{$donasis->email}}</td>
								<td class="pull-right">Rp. {{format_uang($donasis->jumlah)}}</td>
								<td>{{$donasis->type}}</td>
								<td>@if($donasis->status == 'sampai' || $donasis->status=="settlement" ||  $donasis->status=="success")
									<span class="label label-success" style="font-size: 13px;"><i class="fa fa-check-circle-o"> {{ $donasis->status}}</i></span>
									@elseif($donasis->status == 'pending')
									<span class="label label-warning" style="font-size: 13px;"><i class="fa fa-spinner"> {{ $donasis->status}}</i> </span>
									@else
									<span class="label label-danger" style="font-size: 13px;"><i class="fa fa-spinner"> {{ $donasis->status}}</i> </span>
									@endif
								</td>
							</tr>
							@endforeach

						</tbody>
					</table>

					@elseif(Request::get('status') == 'manual')
					<div class="box" style="margin-top: 60px;">
						<div class="box-body">
							<table class="table table-bordered table-striped donasiuser" style="width: 100%">
								<thead>
									<tr>
										<th>No.</th>
										<th>Invoice</th>
										<th>Nama Pengirim</th>
										<th>Nama Program</th>
										<th>Tanggal</th>
										<th>Email</th>
										<th>Jumlah Donasi</th>
										<th>Metode Bayar</th>
										<th>Bukti Pembayaran</th>
										<th>Ubah Status</th>
									</tr>
								</thead>
		
								<tbody>
		
									@foreach($donasi as $donasis)
									<tr>
										<td></td>
										<td>{{$donasis->invoice}}</td>
										<td>{{$donasis->nama}}</td>
										<td>{{$donasis->url}}</td>
										<td>{{$donasis->created_at}}</td>
										<td>{{$donasis->email}}</td>
										<td class="pull-right">Rp. {{format_uang($donasis->jumlah)}}</td>
										<td>{{$donasis->type}}</td>
										<td>@if($donasis->foto)<img src="{{asset('storage/' . $donasis->foto)}}" class="img img-responsive" >
										@endif
										</td>
										<td>
										@if($donasis->foto)
												<form action="{{route('manage-donasi-user.update',['id' => $donasis->id])}}"
												method="POST">
												@csrf
												<input
												type="hidden"
												value="PUT"
												name="_method">
												
												<input onclick="return confirm('Donasi {{$donasis->nama}} Telah Diterima ?')" 
												type="submit"
												value="Konfirmasi"
												class="btn btn-primary btn-flat">
												
											</form>
										@else
										<form action="{{route('manage-donasi-user.update',['id' => $donasis->id])}}"
												method="POST">
												@csrf
												<input
												type="hidden"
												value="PUT"
												name="_method">
												
												<input onclick="return confirm('Donasi {{$donasis->nama}} Telah Diterima ?')" 
												type="submit"
												value="Konfirmasi"
												class="btn btn-primary btn-flat" disabled="">
												
											</form>
										@endif</td>
									</tr>
									@endforeach
		
								</tbody>
							</table>
					@endif
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
@section('script')
@parent
<script type="text/javascript">
 $(function() {
	vStartDate="{{ $start_date}}"; 
	vEndDate="{{ $end_date}}";
	document.getElementById("date_start").valueAsDate = vStartDate?new Date(vStartDate):new Date();
	document.getElementById("date_end").valueAsDate = vEndDate?new Date(vEndDate):new Date();

	var dTable=$('#donasirange').dataTable({
		'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'responsive':true,
        'info': true,
        'scrollX': true,
        'dom': 'Bfrtip',
        'buttons': [
          {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5,6,7,8,9 ]
                }
            },
        ]
	});

	$("#date_start").keyup ( function() { searchByDate(); } );
	$("#date_start").change( function() { searchByDate(); } );
	$("#date_end").keyup ( function() {	searchByDate(); } );
	$("#date_end").change( function() { searchByDate(); } );
	
	function searchByDate(){
		var dateStart = $('#date_start').val();
		var dateEnd   = $('#date_end').val();
		var url ='manage-donasi-user?date_start='+dateStart+'&date_end='+dateEnd;
		window.open(url,"_self")	
	}
			
});
</script>
@endsection
