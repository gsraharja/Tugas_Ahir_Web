<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class perpusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 3;
        if(strlen($katakunci)){
            $data = mahasiswa::where('nim','like',"%$katakunci%")
                    ->orWhere('nama','like',"%$katakunci%")
                    ->orWhere('jurusan','like',"%$katakunci%")
                    ->paginate($jumlahbaris);
        }else{
            $data = mahasiswa::orderBy('nim','desc')->paginate($jumlahbaris);
        }
        return view('beranda.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('beranda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('nim',$request->nim);
        Session::flash('nama',$request->nim);
        Session::flash('jurusan',$request->nim);
        $request->validate([
            'nim'=>'required|numeric|unique:mahasiswa,nim',
            'nama'=>'required',
            'jurusan'=>'required|numeric',
        ],[
            'nim.required'=>'ID wajid diisi',
            'nim.numeric'=>'ID wajid dalam angka',
            'nim.unique'=>'ID yang diisikan sudah ada dalam database',
            'nama.required'=>'Nama Barang wajid diisi',
            'jurusan.required'=>'Jumlah wajid diisi',
            'jurusan.numeric'=>'Jumlah wajid dalam angka',
        ]);
        $data = [
            'nim'=>$request->nim,
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
        ];
        mahasiswa::create($data);

        return redirect()->to('beranda')->with('success','Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = mahasiswa::where('nim',$id)->first();
        return view('beranda.edit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama'=>'required',
            'jurusan'=>'required',
        ],[
            'nama.required'=>'Nama Barang wajid diisi',
            'jurusan.required'=>'Jumlah wajid diisi',
        ]);
        $data = [
            'nama'=>$request->nama,
            'jurusan'=>$request->jurusan,
        ];
        mahasiswa::where('nim',$id)->update($data);

        return redirect()->to('beranda')->with('success','Berhasil mengubah data');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        mahasiswa::where('nim',$id)->delete();
        return redirect()->to('beranda')->with('success','Berhasil menghapus data');
    }
}
