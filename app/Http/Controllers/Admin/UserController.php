<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $list = DB::table('users')
            ->select('id', 'fullname', 'username', 'email', 'phone', 'status')
            ->orderBy('fullname')
            ->get();

        return view('admin.users.index', compact('list'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}