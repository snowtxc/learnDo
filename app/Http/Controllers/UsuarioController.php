<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use PhpParser\Node\Stmt\Unset_;
use App\Http\Controllers\MailController;
use App\Models\UserStatus;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //
         //
        $validator = Validator::make($req->all(),[
            "nickname" => "required|string|max:100",
            "email" => "required|string",
            "password" => "required|string",
            "telefono" => "required|string",
            "nombre" => "required|required",
            "imagen" => "string",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $alreadyExists = DB::table("usuarios")->where("email", $req->email)->first();

        if (isset($alreadyExists)) {
            return response()->json([
                "ok" => false,
                "msg" => "Ya existe un usuario con este email",
            ]);
        }

        $hashPassword = bcrypt($req->password);
        
        $user = new Usuario();
        $user->nickname = $req->nickname;
        $user->email = $req->email;
        $user->password = $hashPassword;
        $user->telefono = $req->telefono;
        $user->nombre = $req->nombre;
        $user->imagen = $req->imagen;
        $user->creditos_number = isset($req->creditos_number) ? $req->creditos_number : 0;
        $user->status_id = 1;
        $user->save();

        $mailController = new MailController("Account Activation", $user->email);
        $mailController->html_email_confirm_account($user->id);

        return $this->signin($req);
    }

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('jwt', ['except' => ['signin', 'create', 'activate']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    public function me() {
        $userInfo = auth()->user();
        unset($userInfo['password']);

        return response()->json([
            "userInfo" => $userInfo,
        ]);
    }

    public function activate(Request $req) {
        $uid = $req->uid;
        $user = Usuario::where("id", $uid)->update(['status_id' => 2]);
        
        return response()->json([
            "ok" => true,
            "message" => "Account activated",
        ]);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
