<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Blog;
use App\Models\Tenant;
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
        // dd(json_encode($users));
        return view('dashboard', ['users' => $users]);
    }else{
        return redirect()->intended(route('login'));  
    }
    }


    public function approve(Request $request){
        if (Gate::allows("check-user", auth()->user())) {
            $user = User::find(intval($request->get('id')));
        
            if ($user) {
                $user->update([
                    'is_approve' => intval($request->get('is_approve'))
                ]);
                return redirect()->intended(route('dashboard'));
            } else {
                return back()->with('error', 'User not found.');
            }
        } else {
            return back()->with('error', 'You do not have access.');
        }
      }


      public function create_blog(Request $request){
        return view('create_blog');
      }
     
      public function create_blog_send(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'snippet' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Gate::allows("check-user", auth()->user())) {
        $tenant = Tenant::where('domain', $request->root())->firstOrFail();
        Blog::create([
            'title'=>$request->title,
            'heading'=>$request->snippet,
            'body'=>$request->body,
            'user_id'=>auth()->user()->id,
            'tenant_id'=>$tenant->id,
        ]);
        return redirect()->intended(route('create_blog'));
      }else{
        return back()->with('error', 'You do not have access.');
      }
      }

      public function list(Request $request){
         $blog = Blog::paginate(10)->appends($request->query());
        return view('list', ['blogs'=>$blog]);
      }

      public function del_list(Request $request){
        $blog = Blog::find(intval($request->get('id')));
        if($blog){
            $blog->delete();
            return redirect()->intended(route('list'));  
        }
      }

      public function edit_blog(Request $request, $id){
        $blog = Blog::find(intval($id));
        if($blog){
        return view('edit_blog', ['blog'=>$blog, 'id'=>$id]);
        }
      }


      public function create_blog_edit(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'snippet' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $blog = Blog::find(intval($id));
        if($blog){
            $blog->title = $request->title;
            $blog->heading = $request->snippet;
            $blog->body = $request->body;
            $blog->save();
            return redirect()->intended(route('list'));  
        }
      }
}
