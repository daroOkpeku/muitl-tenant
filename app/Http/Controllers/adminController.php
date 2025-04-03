<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
class adminController extends Controller
{
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

                if ($user->is_admin == 1) {
                    $request->session()->put('user', auth()->user());
                    return redirect()->intended(route('dashboard'));
                } else {
                   
                    return back()->with('error', 'Account not approved');
                }
        }

        return back()->with('error', 'Unauthorized');

    }


    public function login_view(Request $request){
     
        return view('login');
    }


    public function dashboard (Request $request){
        if(Gate::allows("check-user", auth()->user())){
        $users = User::query();

        // Example: Add search filtering
        if ($request->has('search')) {
            $search = $request->get('search');
            if ($search === 'Approve' || $search === 'approve') {
                $users->where('is_admin', 1);
            }
            elseif ($search === 'disapprove') {
                $users->where('is_admin', 1);
            }
            else {
                $users->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
        }
        
        $users = $users->paginate(10)->appends($request->query());
        return view('dashboard', ['users' => $users]);
    }else{
        return redirect()->intended(route('login'));  
    }
    }


    public function approve(){
        

    }

}
