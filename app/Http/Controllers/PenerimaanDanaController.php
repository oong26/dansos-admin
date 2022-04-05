<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Masyarakat;
use App\Models\PenerimaanDana;
use Illuminate\Http\Request;

class PenerimaanDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PenerimaanDana::select('penerimaan_dana.*', 'masyarakat.nama')
                                ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
                                ->orderBy('penerimaan_dana.status')
                                ->orderBy('penerimaan_dana.nik')
                                ->paginate(5);

        return view('penerimaan-dana.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nik = Masyarakat::select('nik', 'nama')->orderBy('nik')->get();

        return view('penerimaan-dana.create', compact('nik'));
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
            'nik' => 'required|not_in:0',
            'tanggal' => 'required',
            'nominal' => 'required',
            'status' => 'required|not_in:0',
        ], [
            'required' => ':attribute harus diisi.',
            'not_in' => ':attribute harus dipilih.'
        ], [
            'nik' => 'NIK',
            'tanggal' => 'Tanggal',
            'nominal' => 'Nominal',
            'status' => 'Status'
        ]);

        try {
            \DB::beginTransaction();

            $newPenerimaan = new PenerimaanDana;
            $newPenerimaan->nik = $request->nik;
            $newPenerimaan->tanggal = $request->tanggal;
            $newPenerimaan->nominal = $request->nominal;
            $newPenerimaan->status = $request->status;

            $newPenerimaan->save();

            $newHistory = new History;
            $newHistory->id_penerimaan_dana = $newPenerimaan->id;

            $newHistory->save();

            \DB::commit();
            
            return redirect('/penerimaan-dana')->withStatus('Berhasil menyimpan data');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
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
            $nik = Masyarakat::select('nik', 'nama')->orderBy('nik')->get();
            $data = PenerimaanDana::find($id);

            return view('penerimaan-dana.edit', compact('data', 'nik'));
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
        // $this->validate($request, [
        //     'nik' => 'required|not_in:0',
        //     'tanggal' => 'required',
        //     'nominal' => 'required',
        //     'status' => 'required|not_in:0',
        // ], [
        //     'required' => ':attribute harus diisi.',
        //     'not_in' => ':attribute harus dipilih.'
        // ], [
        //     'nik' => 'NIK',
        //     'tanggal' => 'Tanggal',
        //     'nominal' => 'Nominal',
        //     'status' => 'Status'
        // ]);

        try {
            // $editPenerimaan = PenerimaanDana::find($id);
            // $editPenerimaan->nik = $request->nik;
            // $editPenerimaan->tanggal = $request->tanggal;
            // $editPenerimaan->nominal = $request->nominal;
            // $editPenerimaan->status = $request->status;

            // $editPenerimaan->save();
            \DB::beginTransaction();

            $editPenerimaan = PenerimaanDana::find($id);
            $editPenerimaan->status = 2;

            $editPenerimaan->save();

            $newHistory = new History;
            $newHistory->id_penerimaan_dana = $id;
            $newHistory->status = 2;
            
            $newHistory->save();

            \DB::commit();

            return redirect('/penerimaan-dana')->withStatus('Berhasil menyimpan data');
        } catch (\Exception $e) {
            \DB::rollback();

            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();

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
            PenerimaanDana::find($id)->delete();

            return redirect('/penerimaan-dana')->withStatus('Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }
}