<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class AuthController extends Controller
{


    public function register(Request $request){
        $userRequest = $request->all();

        // validation
        $validator = Validator::make($userRequest,[
            'name' => 'required',
            'email' => 'required|email|uniq',
            'phoneNumber' => 'required',
            'password' => 'required',
            'address' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()->all(),
                'status' => false
            ],400);
        }

        // user create
        $userCreate = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address
        ]);

        // create token
        $success['token'] = $userCreate->createToken('myApp')->accessToken;

        return response()->json([
            'data' => $userCreate,
            'message' => 'success message',
            'token' => $success['token'],
            'status' => true
        ]);
    }

    public function login(Request $request){
        try{
            $userRequest = $request->all();
            // make validation
            $validation = Validator::make($userRequest,[
                'email' => 'required',
                'password' => 'required'
            ]);
            // validation error
            if($validation->fails()){
                return response()->json([
                    'message' => $validation->errors()->all(),
                    'status' => false,
                ],400);
            }
            // check user auth [ email and password ]
            if(Auth::guard('web')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])){
                $user = Auth::guard('web')->user();
                $success['token'] = $user->createToken('my App')->accessToken;
                return response()->json([
                    'data' => $user,
                    'token' => $success['token'],
                    'message' => 'success message',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'message' => 'email or password not correct',
                    'status' => false
                ],401);
            }
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => false
            ],500);
        }
    }
//    /**
//     * Register user.
//     *
//     * @return json
//     */
//    public function register(RegisterRequest $request)
//    {
//        $newUser= $request->all();
//        $newUser['password']=Hash::make($request->get('password'));
//        $user = User::create($newUser);
//
//        return response()->json([
//            'success' => true,
//            'message' => 'User registered successfully, Use Login method to receive token.'
//        ], 200);
//    }
//
//    /**
//     * Login user.
//     *
//     * @return json
//     */
//    public function login(Request $request)
//    {
//        $input = $request->only(['email', 'password']);
//
//        $validate_data = [
//            'email' => 'required|email',
//            'password' => 'required|min:8',
//        ];
//
//        $validator = Validator::make($input, $validate_data);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Please see errors parameter for all errors.',
//                'errors' => $validator->errors()
//            ]);
//        }
//
//        // authentication attempt
//        if (auth()->attempt($input)) {
//            $token = auth()->user()->createToken('passport_token')->accessToken;
//
//            return response()->json([
//                'success' => true,
//                'message' => 'User login successfully, Use token to authenticate.',
//                'token' => $token
//            ], 200);
//        } else {
//            return response()->json([
//                'success' => false,
//                'message' => 'User authentication failed.'
//            ], 401);
//        }
//    }
//
//    /**
//     * Access method to authenticate.
//     *
//     * @return json
//     */
//    public function userDetail()
//    {
//        return response()->json([
//            'success' => true,
//            'message' => 'Data fetched successfully.',
//            'data' => auth()->user()
//        ], 200);
//    }
//
//    /**
//     * Logout user.
//     *
//     * @return json
//     */
//    public function logout()
//    {
//        $access_token = auth()->user()->token();
//
//        // logout from only current device
//        $tokenRepository = app(TokenRepository::class);
//        $tokenRepository->revokeAccessToken($access_token->id);
//
//        // use this method to logout from all devices
//        // $refreshTokenRepository = app(RefreshTokenRepository::class);
//        // $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($$access_token->id);
//
//        return response()->json([
//            'success' => true,
//            'message' => 'User logout successfully.'
//        ], 200);
//    }
}
