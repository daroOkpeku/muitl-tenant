<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserAuthController extends Controller
{
    

    public function register(Request $request){


        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $tenant = Tenant::where('domain', $request->root())->firstOrFail();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_approve'=>0,
            'tenant_id'=>$tenant->id,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message'=>"you have created your account"
            // 'token' => $user->createToken('TenantApp')->accessToken,
        ]);

    }


    public function login(Request $request){
        // dd($request->all());
        // $request->validate([
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required|min:6',
        // ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
          
        if (auth()->attempt($request->only('email', 'password'))) {
                $user = auth()->user();

                if ($user->is_approve == 1) {
                    return response()->json([
                        'user' => $user,
                        'token' => $user->createToken('TenantApp')->accessToken,
                    ]);
                } else {
                    return response()->json(['message' => 'Account not approved'], 403);
                }
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function list(Request $request){
        $blog = Blog::paginate(10)->appends($request->query());
       return response()->json(['data'=>$blog]);
     }


     public function create_tenant(Request $request){
            $tenant = new Tenant();
                $tenant->id = 1;
                $tenant->name = 'user';
                $tenant->domain = request()->root();
                $tenant->save();
                return response()->json(['message' => 'successfull'], 200);
     }
}
