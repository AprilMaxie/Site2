<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;

Class UserController extends Controller {
    use ApiResponser;

    private $request;
    public function __construct(Request $request){
        $this->request = $request;
    }
    public function getUsers(){
        $users = DB::connection('mysql')
        ->select("Select * from tbluser");
    
            return $this->successResponse($users);  
    }

    public function index(){
        $users = User::all();

            return $this->successResponse($users);
    }

    public function add(Request $request){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request, $rules);
        $user = User::create($request->all());

            return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show($userId){
        $user = User::where('userId', $userId)->first();
        if($user){
            return $this->successResponse($user);
        }

            return $this->errorResponse("User id not found", Response::HTTP_NOT_FOUND);
        }


    public function update(Request $request, $userId)  {
        $user = User::findOrFail($userId);
        $user->update($request->all());

            return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function delete($userId, Request $request)
    {
        $user = User::findOrFail($userId);
        $user->delete($request->all());

        return $this->successResponse($user, Response::HTTP_OK);
    }

}