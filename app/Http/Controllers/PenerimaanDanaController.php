<?php

namespace App\Http\Controllers;

use App\Exports\PenerimaanDanaExport;
use Maatwebsite\Excel\Facades\Excel;
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
        // $search =  $request->input('q');
        // if($search!=""){
        //     return $search;
        //     $data = PenerimaanDana::select('penerimaan_dana.*', 'masyarakat.nama')
        //                         ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
        //                         ->where(function ($query) use ($search)
        //                         {
        //                             $query->where('penerimaan_dana.nik','like','%'.$search.'%');
        //                         })
        //                         ->orderBy('penerimaan_dana.status')
        //                         ->orderBy('penerimaan_dana.nik')
        //                         ->paginate(5);
            // $Members = Member::where(function ($query) use ($search){
            //     $query->where('name', 'like', '%'.$search.'%')
            //         ->orWhere('email', 'like', '%'.$search.'%');
            // })->paginate(2);
        //     $data->appends(['q' => $search]);
        // }
        // else{
            $data = PenerimaanDana::select('penerimaan_dana.*', 'masyarakat.nama')
                                ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
                                ->orderBy('penerimaan_dana.status')
                                ->orderBy('penerimaan_dana.nik')
                                ->paginate(5);
        // }
        // $data = PenerimaanDana::select('penerimaan_dana.*', 'masyarakat.nama')
        //                         ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
        //                         ->orderBy('penerimaan_dana.status')
        //                         ->orderBy('penerimaan_dana.nik')
        //                         ->paginate(5);

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

    public function multipleKonfirmasi(Request $request)
    {
        // return response()->json($request->ids);
        \DB::beginTransaction();
        try {
            for ($i=0; $i < count($request->ids); $i++) {
                $editPenerimaan = PenerimaanDana::find($request->ids[$i]);
                $editPenerimaan->status = 2;

                $editPenerimaan->save();

                $newHistory = new History;
                $newHistory->id_penerimaan_dana = $editPenerimaan->id;
                $newHistory->status = 2;

                $newHistory->save();
            }

            \DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function exportExcel($page)
    {
        $take = 5;
        $skip = 0;

        if($page > 1) {
            for ($i=1; $i < $page; $i++) {
                $skip += 5;
            }
        }

        $data = PenerimaanDana::select('penerimaan_dana.*', 'masyarakat.nama')
                                ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
                                ->skip($skip)
                                ->take($take)
                                ->orderBy('penerimaan_dana.status')
                                ->orderBy('penerimaan_dana.nik')
                                ->get();

        return Excel::download(new PenerimaanDanaExport($data), 'penerimaan-dana.xlsx');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        if($search != '')
            $data = PenerimaanDana::select('penerimaan_dana.*', 'masyarakat.nama')
                        ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
                        ->orderBy('penerimaan_dana.status')
                        ->orderBy('penerimaan_dana.nik')
                        ->where('penerimaan_dana.nik','like','%'.$search.'%')
                        ->paginate(5);
                // $services = Service::where('service_name','like', '%' .$search. '%')->paginate(2);
                $data->appends(array('search'=> Input::get('search'),));

        if(count($data )>0){
                return view('penerimaan-dana.index',['data'=>$data]);
        }
        return back()->with('error','No results Found');

    }
}
