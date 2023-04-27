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
        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return $this->respondUnprocessableEntity('Sai toàn khoản hoặc mật khẩu');
        }

        $tokenResult = auth()->user()->createToken('Personal Access Token');
        dd( $tokenResult);
        // localStorage.setItem('user_id', auth()->user()->id);
        // localStorage.setItem('access_token', $tokenResult->accessToken);
        return $this->respondSuccess([
            'id' => auth()->user()->id,
            'email' => auth()->user()->email,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
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