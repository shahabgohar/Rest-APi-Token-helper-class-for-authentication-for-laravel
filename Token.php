<?php
namespace App\Token;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;

class Token{

    /**
     * @return string
     */
    private static function setKey()
    {
        return config()->get('Token.Api_Token.Key');
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse|object
     */
    private static function DecodeToken($token)
    {
        $token = JWT::decode($token,Static::setkey(),array('HS256'));
        if(isset($token->exception))
        {
            return response()->json(['error'=>'invalid user']);
        }
        return $token;
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    private static function TokenExpired($token)
    {
        $token=Static::DecodeToken($token);
        if(Carbon::parse($token->iat,'Asia/Karachi')->diffInDays(Carbon::parse($token->nbf,'Asia/Karachi'))<=0)
        {
            return response()->json(['error' => 'token expired']);
        }
        return $token;
    }

    /**
     * @param $token
     * @return mixed
     */
    public static function GetUserFromToken($token)
    {
        $token=Static::TokenExpired($token);
        $user= User::where('api_token',$token->user)->first();
        return $user;
    }

    public static function VerifyUser($token)
    {
        $user = Static::GetUserFromToken($token);
        if($user==null)
            return null;
        else
            return $user;
    }

    /**
     * @param $token
     * @return bool
     */
    public static function AuthenticateToken($token)
    {
        Static::TokenExpired($token);

    }

    /**
     * @param $user
     * @return array
     */
    private static function GetPayload($user)
    {
        $payload=[
            'user' => $user->api_token,
            'aud' => "http://127.0.0.1:8000",
            'is_admin'=>$user->is_admin,
            'iat' => Carbon::now('Asia/Karachi')->toDayDateTimeString(),
            'nbf' => Carbon::now('Asia/Karachi')->addDay(25)->toDayDateTimeString()
        ];
        return $payload;
    }
    /**
     * @param $payload
     */
    private static function EncodeToken($user)
    {
       return JWT::encode(static::GetPayload($user),Static::setkey());
    }
    public static function GenerateToken($user)
    {

        return static::EncodeToken($user);
    }
    public static function AdminUser($token)
    {
        $user = Static::GetUserFromToken($token);
        if($user->is_admin)
            return response()->json(['admin'=>true,'message'=>'user is admin'],200);
        else
            return response()->json(['admin' => false,'message'=>'user is not admin'],422);
    }
    public function GetUserIdFromToken($token)
    {
        return Static::GetUserFromToken($token)->id;
    }
}
