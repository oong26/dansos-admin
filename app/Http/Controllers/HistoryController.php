<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = null;
        
            if(isset($request->dari) && isset($request->sampai)) {
                $dari = $request->dari.' 00:00:00';
                $sampai = $request->sampai.' 23:59:59';
                $data = History::select(
                                    'penerimaan_dana.nominal',
                                    'masyarakat.nik',
                                    'masyarakat.nama',
                                    'history.*'
                                )
                                ->join('penerimaan_dana', 'penerimaan_dana.id', 'history.id_penerimaan_dana')
                                ->join('masyarakat', 'masyarakat.nik', 'penerimaan_dana.nik')
                                ->whereBetween('history.created_at', [$dari, $sampai])
                                ->orderBy('history.status')
                                ->orderBy('penerimaan_dana.nik')
                                ->get();
            }

            return view('history.index', compact('data'));
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }
}
