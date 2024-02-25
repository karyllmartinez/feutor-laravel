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
            'temail' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::guard('tutors')->attempt(['temail' => $request->temail, 'password' => $request->password])) {
            // Get the authenticated tutor
            $tutor = Auth::guard('tutors')->user();
    
            // Redirect the tutor to a protected page
            return redirect('/tutors/dashboard');
        } else {
            // Authentication failed
            return back()->withErrors(['temail' => 'Invalid email or password']);
        }
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
    if (Auth::guard('tutor')->check()) {
        return view('tutorauth.tdashboard');
    }
    return redirect("tlogin")->withSuccess('You are not allowed to access');
}
public function signOut()
{
    Session::flush();
    Auth::guard('tutor')->logout();
    return Redirect('tlogin');
}
    
}