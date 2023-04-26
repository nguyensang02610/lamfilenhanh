<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends ApiController
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return $this->respondUnprocessableEntity('Sai tài khoản hoặc mật khẩu');
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token', [$user->role]);
        // dd($tokenResult->accessToken->token);
        return $this->respondSuccess([
            'user_id' => $user->id,
            'access_token' => $tokenResult->accessToken->token,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->accessToken->expires_at,
        ]);
    }

    public function logoutUser(Request $request)
    {
        $user = auth()->user()->token();
        $user->revoke();
        return $this->respondSuccess([
            'user' => 'Logout success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}