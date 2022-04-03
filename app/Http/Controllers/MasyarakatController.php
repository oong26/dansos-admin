<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = Masyarakat::orderBy('id')->paginate(5);

        return view('masyarakat.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masyarakat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|unique:masyarakat,nik',
            'nama' => 'required',
            'no_hp' => 'required|unique:masyarakat,no_hp',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute telah digunakan.',
        ], [
            'nik' => 'NIK',
            'nama' => 'Nama',
            'no_hp' => 'No. HP',
            'alamat' => 'Alamat',
            'jenis_kelamin' => 'Jenis kelamin',
            'tanggal_lahir' => 'Tanggal lahir',
        ]);

        try {
            $newMasyarakat = new Masyarakat;
            $newMasyarakat->nik = $request->nik;
            $newMasyarakat->nama = $request->nama;
            $newMasyarakat->alamat = $request->alamat;
            $newMasyarakat->jenis_kelamin = $request->jenis_kelamin;
            $newMasyarakat->tanggal_lahir = $request->tanggal_lahir;
            $newMasyarakat->no_hp = $request->no_hp;

            $newMasyarakat->save();

            return redirect('/masyarakat')->withStatus('Berhasil menyimpan data');
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Masyarakat::find($id);

            return view('masyarakat.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $editMasyarakat = Masyarakat::find($id);

            $this->validate($request, [
                'nama' => 'required',
                'alamat' => 'required',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required',
            ], [
                'required' => ':attribute harus diisi.',
                'unique' => ':attribute telah digunakan.',
            ], [
                'nama' => 'Nama',
                'alamat' => 'Alamat',
                'jenis_kelamin' => 'Jenis kelamin',
                'tanggal_lahir' => 'Tanggal lahir',
            ]);
            
            $editMasyarakat->nama = $request->nama;
            $editMasyarakat->alamat = $request->alamat;
            $editMasyarakat->jenis_kelamin = $request->jenis_kelamin;
            $editMasyarakat->tanggal_lahir = $request->tanggal_lahir;

            $editMasyarakat->save();

            return redirect('/masyarakat')->withStatus('Berhasil menyimpan data');
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Masyarakat::find($id)->delete();

            return redirect('/masyarakat')->withStatus('Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }
}
