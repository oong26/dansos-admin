<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Artikel::orderBy('id')->paginate(5);

        return view('artikel.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('artikel.create');
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
            'title' => 'required|unique:artikel,title',
            'cover' => 'required',
            'konten' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
            'title.unique' => 'Judul telah digunakan.',
        ], [
            'title' => 'Judul',
            'cover' => 'Cover',
            'konten' => 'Konten',
        ]);

        try {
            if($request->file('cover') != null) {

                $folder = 'upload/artikel';
                $file = $request->file('cover');
                $filename = date('YmdHis').$file->getClientOriginalName();
                // Get canonicalized absolute pathname
                $path = realpath($folder);

                // If it exist, check if it's a directory
                if(!($path !== true AND is_dir($path)))
                {
                    // Path/folder does not exist then create a new folder
                    mkdir($folder, 0755, true);
                }
                $newArtikel = new Artikel;
                $newArtikel->title = $request->title;
                $newArtikel->slug = \Str::slug($request->title, '-');
                $newArtikel->konten = $request->konten;

                if ($request->file('video') != null) {
                    $folder_video = 'upload/artikel';
                    $file_video = $request->file('video');
                    $filename_video = $file_video->getClientOriginalName();
                    // Get canonicalized absolute pathname
                    $path = realpath($folder_video);

                    // If it exist, check if it's a directory
                    if(!($path !== true AND is_dir($path)))
                    {
                        // Path/folder does not exist then create a new folder
                        mkdir($folder_video, 0755, true);
                    }
                }

                if($file_video->move($folder_video, $filename_video)) {

                    $newArtikel->upload_video = $filename_video;

                }

                if($file->move($folder, $filename)) {

                    $newArtikel->cover = $filename;

                }
                $newArtikel->save();
            }

            return redirect('/artikel')->withStatus('Berhasil menyimpan data');
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
            $data = Artikel::find($id);

            return view('artikel.edit', compact('data'));
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
            $artikel = Artikel::find($id);

            if(($request->title != null && $request->title != $artikel->title)) {
                $exists = Artikel::select('title')->where('title', $request->title)->get();
                if($exists != null && count($exists) > 0)
                    return back()->withError('Judul telah digunakan');
            }

            $this->validate($request, [
                'title' => 'required',
                'konten' => 'required',
            ], [
                'required' => ':attribute harus diisi.',
            ], [
                'title' => 'Judul',
                'konten' => 'Konten',
            ]);

            if($request->file('cover') != null) {
                $folder = 'upload/artikel';
                $file = $request->file('cover');
                $filename = date('YmdHis').$file->getClientOriginalName();
                // Get canonicalized absolute pathname
                $path = realpath($folder);

                // If it exist, check if it's a directory
                if(!($path !== true AND is_dir($path)))
                {
                    // Path/folder does not exist then create a new folder
                    mkdir($folder, 0755, true);
                }
                if($file->move($folder, $filename)) {
                    $artikel->title = $request->title;
                    $artikel->slug = \Str::slug($request->title, '-');
                    $artikel->cover = $filename;
                    $artikel->konten = $request->konten;

                    $artikel->save();
                }
            }
            else {
                $artikel->title = $request->title;
                $artikel->slug = \Str::slug($request->title, '-');
                $artikel->konten = $request->konten;

                $artikel->save();
            }

            return redirect('/artikel')->withStatus('Berhasil menyimpan data');
        } catch (\Exception $e) {
            return $e->getMessage();
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
            $artikel = Artikel::findOrFail($id);
            $dir = 'upload/artikel/';
            if(unlink($dir.$artikel->cover))
                $artikel->delete();

            return redirect('/artikel')->withStatus('Berhasil menghapus data.');
        }
        catch(\Exception $e){
            return back()->withError($e->getMessage());
        }
        catch(\Illuminate\Database\QueryException $e){
            return back()->withError($e->getMessage());
        }
    }
}
