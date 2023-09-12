<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use function Symfony\Component\Mime\Header\all;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index()
    {
        if(request()->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="javascript:void(0)" id="createNewUser" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm btn-edit">Edit</a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm btn-delete">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('welcome');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);
        User::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->name)
            ]);

        return response()->json(['success' => 'Post saved successfully.']);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        $userData = User::find($id);
        return response()->json([
            'success' => 'Post saved successfully.',
            'data' => $userData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['success'=>'Post deleted successfully.']);
    }
}
