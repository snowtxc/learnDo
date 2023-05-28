<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Organizador;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\MailController;
use App\Http\Utils\UserUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        $validator = Validator::make($req->all(), [
            "nickname" => "required|string|max:100",
            "email" => "required|string",
            "password" => "required|string",
            "telefono" => "required|string",
            "nombre" => "required|required",
            "biografia" => "required|string|max:250",
            "rol" => "required|string",
            "imagen" => "required|string",
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $emailAlreadyExists = DB::table("usuarios")->where("email", $req->email)->first();

        if (isset($emailAlreadyExists)) {
            return response()->json([
                "ok" => false,
                "msg" => "Ya existe un usuario con este email",
            ], 401);
        }

        $nicknameAlreadyExists = DB::table("usuarios")->where("nickname", $req->nickname)->first();

        if (isset($nicknameAlreadyExists)) {
            return response()->json([
                "ok" => false,
                "msg" => "Ya existe un usuario con este nickname",
            ], 401);
        }

        $hashPassword = bcrypt($req->password);

        $user = new Usuario();

        // al insertar, pasarle el user_id al new estudiante

        $user->nickname = $req->nickname;
        $user->email = $req->email;
        $user->password = $hashPassword;
        $user->telefono = $req->telefono;
        $user->nombre = $req->nombre;
        $user->biografia = $req->biografia;
        $user->imagen = $req->imagen;
        $user->creditos_number = isset($req->creditos_number) ? $req->creditos_number : 0;
        $user->type = $req->rol;
        $user->status_id = 1;
        $user->save();

        // Creo el user en la tabla estudiante / organizador
        if ($req->rol === 'estudiante') {
            $estudiante = new Estudiante();
            // $statement = DB::select("SHOW TABLE STATUS LIKE 'usuarios'");
            // $nextId = $statement[0]->Auto_increment; // obtengo el siguiente id autogenerado por la secuencia
            $estudiante->user_id = $user->id;
            $estudiante->save();
        } else if ($req->rol === 'organizador') {
            $organizador = new Organizador();
            // $statement = DB::select("SHOW TABLE STATUS LIKE 'usuarios'");
            // $nextId = $statement[0]->Auto_increment; // obtengo el siguiente id autogenerado por la secuencia
            $organizador->user_id = $user->id;
            $organizador->save();
        }

        $mailController = new MailController("Account Activation", $user->email);
        $mailController->html_email_confirm_account($user->id);

        return response()->json([
            "ok" => true,
            "message" => "Cuenta creada correctamente"
        ]);
    }

    public function changeUserRole(Request $req)
    {
        //
        //
        $validator = Validator::make($req->all(), [
            "uid" => "required|int|max:100",
            "role" => [
                "required",
                Rule::in(['organizador', 'estudiante'])
            ],
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $userExists = DB::table("usuarios")->where("id", $req->uid)->first();

        if (!isset($userExists)) {
            return response()->json([
                "ok" => false,
                "msg" => "Error, el usuario no existe",
            ], 401);
        }
        
        Usuario::where("id", $req->uid)->update(['type' => $req->role]);

        // Creo el user en la tabla estudiante / organizador
        if ($req->role === 'estudiante') {
            $estudiante = new Estudiante();
            $estudiante->user_id = $req->uid;
            $estudiante->save();
        } else if ($req->role === 'organizador') {
            $organizador = new Organizador();
            $organizador->user_id = $req->id;
            $organizador->save();
        };

        return response()->json([
            "ok" => true,
            "msg" => "Usuario actualizado correctamente"
        ]);
    }

    public function createUserWithOauth(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "nickname" => "string|max:100",
            "email" => "required|string",
            "password" => "string",
            "telefono" => "string",
            "nombre" => "required",
            "rol" => "string",
            "imagen" => "string",
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $emailAlreadyExists = DB::table("usuarios")->where("email", $req->email)->first();
        $uidAlreadyExists = DB::table("usuarios")->where("oauthId", $req->uid)->first();


        if (isset($emailAlreadyExists) || isset($uidAlreadyExists)) {
            $emailToValidate = isset($emailAlreadyExists) ? $emailAlreadyExists->email : $uidAlreadyExists->email;
            $credentials = [
                "email" => $emailToValidate
            ];
            $token = ($user = Auth::getProvider()->retrieveByCredentials($credentials))
            ? Auth::login($user)
            : false;
            return response()->json([
                "ok" => true,
                "token" => $token,
            ], 200);
        }


        $nicknameAlreadyExists = DB::table("usuarios")->where("nickname", $req->nickname)->first();

        $userNickname = $req->nickname;
        if (isset($nicknameAlreadyExists)) {
            $userNickname = $req->nickname . rand(1, 1000);
        }

        $user = new Usuario();

        // al insertar, pasarle el user_id al new estudiante

        $user->nickname = $userNickname;
        $user->email = $req->email;
        $user->telefono = $req->telefono ? $req->telefono : 0;
        $user->nombre = $req->nombre; 
        $user->oauthId = $req->uid; 
        $user->imagen = $req->imagen;
        $user->creditos_number = 0;
        $user->biografia = $req->biografia ? $req->biografia : "";
        $user->type = $req->rol ? $req->rol : "";
        $user->password = "NO_PROVIDE_OAUTH";
        $user->status_id = 2;
        $user->save();

        // Creo el user en la tabla estudiante / organizador
        if ($req->rol === 'estudiante') {
            $estudiante = new Estudiante();
            // $statement = DB::select("SHOW TABLE STATUS LIKE 'usuarios'");
            // $nextId = $statement[0]->Auto_increment; // obtengo el siguiente id autogenerado por la secuencia
            $estudiante->user_id = $user->id;
            $estudiante->save();
        } else if ($req->rol === 'organizador') {
            $organizador = new Organizador();
            // $statement = DB::select("SHOW TABLE STATUS LIKE 'usuarios'");
            // $nextId = $statement[0]->Auto_increment; // obtengo el siguiente id autogenerado por la secuencia
            $organizador->user_id = $user->id;
            $organizador->save();
        };

        $credentials = [
            "email" => $req["email"],
        ];

        $token = ($user = Auth::getProvider()->retrieveByCredentials($credentials))
            ? Auth::login($user)
            : false;

        return response()->json([
            "ok" => true,
            "token" => $token
        ]);
    }


    public function checkNickname(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "nickname" => "required|string|max:100",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = DB::table("usuarios")->where("nickname", $req->nickname)->first();
        return response()->json(["existe" => isset($user)]);
    }

    public function filterByNicknameOrEmail(Request $req) {
        $validator = Validator::make($req->all(),[
            "value" => "required|string|max:100",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),500);
        }

        $users = DB::table("usuarios")->select('id', 'nickname', 'email', 'telefono', 'nombre', 'biografia', 'imagen', 'status_id', 'creditos_number', 'type')->where("nickname", 'LIKE', '%'.$req->value.'%')
        ->orWhere("email", "LIKE", "%".$req->value."%")
        ->get();
        return response()->json($users);
    }

     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('jwt', ['except' => ['signin', 'create', 'activate', 'checkNickname', "signupWithOauth", 'filterByNicknameOrEmail', "createUserWithOauth", "changeUserRole"]]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->checkUserStatus($token);
    }

    public function checkUserStatus($token)
    {
        $user = auth()->user();
        if ($user->status_id === 1) {
            return response()->json(["ok" => false, "message" => "Cuenta desactivada"]);
        }
        ;
        return $this->createNewToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    public function me()
    {
        $userInfo = auth()->user();
        unset($userInfo['password']);

        return response()->json([
            "userInfo" => $userInfo,
        ]);
    }

    public function activate(Request $req)
    {
        $token = $req->uid;
        if (!isset($token) || $token == null) {
            return response()->json([
                "ok" => false,
                "message" => "Error validando token",
            ]);
        }
       
        try {
            list($header, $payload, $signature) = explode('.', $token);
            $jsonToken = base64_decode($payload);
            $claims = json_decode($jsonToken, true);

            $userId = $claims["user_id"];
            $userInfo = Usuario::find($userId);
            // DB::table("usuarios")->where("id", "$req->uid")->first();
            if ($userId === null || $userInfo === null) {
                return response()->json([
                    "ok" => false,
                    "message" => "User not found",
                ]);
                return;
            }
            Usuario::where("id", $userId)->update(['status_id' => 2]);
            $updatedUserInfo = Usuario::find($userId)->toArray();
            // echo var_dump($updatedUserInfo);
            $credentials = [
                "email" => $updatedUserInfo["email"],
            ];
            $token = ($user = Auth::getProvider()->retrieveByCredentials($credentials))
                ? Auth::login($user)
                : false;

            return $this->createNewToken($token);
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                "ok" => false,
                "message" => "Error validando token",
            ]);
            //throw $th;
        }


        // return response()->json([
        //     "ok" => true,
        //     "message" => "Account activated",
        //     "userInfo" => $user,
        // ]);
        Usuario::where("id", $userId)->update(['status_id' => 2]);
        $updatedUserInfo = Usuario::find($userId)->toArray();
        // echo var_dump($updatedUserInfo);
        $credentials = [
            "email" => $updatedUserInfo["email"],
        ];
        $token = ($user = Auth::getProvider()->retrieveByCredentials($credentials))
            ? Auth::login($user)
            : false;
        
        return $this->createNewToken($token);
        

    }  

    function editMeInfo(Request $request){
        $user = auth()->user();
        $userId = $user->id;
        $validator = Validator::make($request->all(), [
                           //faltaria el apellido
            'nombre' => 'required', 
            'telefono' => 'required',
            'imagen' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        Usuario::where("id", $userId)->update(['nombre' => $request->input("nombre"), "telefono" => $request->input("telefono"),"imagen" => $request->input("imagen")]);
        return response()->json([
            "message" => "usuario editado correctamente"
            
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}