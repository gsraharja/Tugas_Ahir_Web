@extends('layout.template')       
<!-- START DATA -->
@section('konten')
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <!-- FORM PENCARIAN -->
            <div class="pb-3">
                <form class="d-flex" action="{{ url('beranda')}}" method="get">
                    <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Masukkan kata kunci" aria-label="Search">

                    <button class="btn btn-secondary" type="submit">Cari</button>
                </form>
            </div>

    <!-- TOMBOL TAMBAH DATA -->
    <div class="pb-3">
        <a href='{{url('beranda/create')}}' class="btn btn-primary">+ Tambah Data</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="col-md-1">No</th>
                <th class="col-md-3">ID</th>
                <th class="col-md-4">Nama Barang</th>
                <th class="col-md-2">Jumlah</th>
                <th class="col-md-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = $data->firstItem()?>
            @foreach ($data as $item)
             <tr>
                <td>{{$i}}</td>
                <td>{{$item->nim}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->jurusan}}</td>
                <td>
                    <a href='{{ url('beranda/'.$item->nim.'/edit')}}' class="btn btn-warning btn-sm">Edit</a>
                    <form onsubmit="return confirm('Yakin akan menghapus data?')" class='d-inline' action="{{ url('beranda/'. $item->nim) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type ="submit" name="submit" class="btn btn-danger btn-sm">Del</button>
                    </form>    
                </td>
            </tr>
            <?php $i++ ?>   
            @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</div>
<!-- AKHIR DATA -->         
@endsection                

