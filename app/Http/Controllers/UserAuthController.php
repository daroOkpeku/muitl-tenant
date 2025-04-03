<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
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
            'token' => $user->createToken('TenantApp')->accessToken,
        ]);

    }


    public function login(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
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
}
