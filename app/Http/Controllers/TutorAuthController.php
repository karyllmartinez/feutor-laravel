<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Tutor;
use Illuminate\Support\Facades\Auth;
class TutorAuthController extends Controller
{
    public function tindex()
    {
        return view('tutorauth.tlogin');
    }
    public function tcustomLogin(Request $request)
{
    $request->validate([
        'temail' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('temail', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('tdashboard')
            ->withSuccess('Signed in');
    }

    return redirect("tlogin")->withSuccess('Login details are not valid');
}
    public function tregistration()
    {
        return view('tutorauth.tregister');
    }
    public function tcustomRegistration(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'temail' => 'required',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $tcheck = $this->create($data);
        return redirect("tdashboard")->withSuccess('You have signed-in');
    }
    public function create(array $data)
    {
        return Tutor::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'temail' => $data['temail'],
            'password' => Hash::make($data['password'])
        ]);
    }
    public function tdashboard()
    {
        if (Auth::check()) {
            return view('tutorauth.tdashboard');
        }
        return redirect("tlogin")->withSuccess('You are not allowed to access');
    }
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('tlogin');
    }
    
}