<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Mostrar el formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Método para manejar el registro
    public function register(Request $request)
    {
       
        // Crear una nueva instancia del modelo User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        // Guardar el nuevo usuario en la base de datos
        $user->save();

        // Iniciar sesión automáticamente después del registro
        Auth::login($user);

        // Redirigir a la vista de administrador
        return redirect()->route('admin.index');
    }

    // Método para manejar el login
    public function login(Request $request)
    {
        // Validar el formulario de login
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Credenciales
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        // Revisar si se marcó la opción "Recuérdame"
        $remember = $request->has('remember');
    
        // Intentar autenticar al usuario
        if (Auth::attempt($credentials, $remember)) {
            // Regenerar la sesión
            $request->session()->regenerate();
    
            // Redirigir a la ruta adecuada
            return redirect()->intended(route('admin.index'));
        }
    
        // En caso de fallo, redirigir de vuelta con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->withInput();
    }
    

    // Método para manejar el logout
  // Método para manejar el logout
public function logout(Request $request)
{
    Auth::logout();

    // Invalida la sesión
    $request->session()->invalidate();

    // Genera un nuevo token CSRF
    $request->session()->regenerateToken();

    // Olvidar la cookie de "remember me" si existe
    \Cookie::forget('remember_web_' . Auth::getRecallerName());

    // Redirigir a la página de login
    return redirect()->route('login');
}

}
