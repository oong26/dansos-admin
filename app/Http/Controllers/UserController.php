<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = User::orderBy('id')->get();

        return view('user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'role' => 'not_in:0'
        ], [
            'required' => ':attribute harus diisi.',
            'email.unique' => 'Email telah digunakan.',
            'role.not_in' => 'Role harus dipilih.'
        ], [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role'
        ]);

        try {
            $newUser = new User;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = \Hash::make($request->password);
            $newUser->role = $request->role;

            $newUser->save();

            return redirect('/user')->withStatus('Berhasil menyimpan data');
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
            $data = User::find($id);

            return view('user.edit', compact('data'));
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
            $editUser = User::find($id);

            $emailUnique = User::select('email')
                                ->where('email', '!=', $editUser->email)
                                ->where('email', $request->email)
                                ->get();

            if(count($emailUnique) > 0)
                return back()->withError('Email telah digunakan');

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'not_in:0'
            ], [
                'required' => ':attribute harus diisi.',
                'email.unique' => 'Email telah digunakan.',
                'role.not_in' => 'Role harus dipilih.'
            ], [
                'name' => 'Nama',
                'email' => 'Email',
                'password' => 'Password',
                'role' => 'Role'
            ]);
            
            $editUser->name = $request->name;
            $editUser->email = $request->email;
            $editUser->password = \Hash::make($request->password);
            $editUser->role = $request->role;

            $editUser->save();

            return redirect('/user')->withStatus('Berhasil menyimpan data');
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
            User::find($id)->delete();

            return redirect('/user')->withStatus('Berhasil menghapus data');
        } catch (\Exception $e) {
            return back()->withError('Terjadi kesalahan. '.$e->getMessage());
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withError('Terjadi kesalahan pada database. '.$e->getMessage());
        }
    }
}
