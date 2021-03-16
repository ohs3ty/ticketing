<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use phpCAS;

class CheckCASAuthentication
{
    /*
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( Auth::check() )
            return $this->catch_cas($next($request));

        phpCAS::client(CAS_VERSION_2_0,'cas.byu.edu',443,'cas');
        phpCAS::setNoCasServerValidation();
        phpCAS::forceAuthentication();
        dd($_SESSION['phpCAS']);
        Auth::login(User::findUser($_SESSION['phpCAS']));

        return $this->catch_cas($next($request));
    }

    private function catch_cas($n)
    {
        if(get_class($n) == "Illuminate\Http\RedirectResponse")
        {
            $url = ($n->getTargetURL());
            if(strpos($url, "cas.byu.edu") !== FALSE)
                return redirect('');
        }
        return $n;
    }
}
