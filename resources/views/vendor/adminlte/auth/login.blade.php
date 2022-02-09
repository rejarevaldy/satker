@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')
    <form action="{{ route('login.store') }}" method="post">
        @csrf

        {{-- User field --}}
        <div class="input-group mb-3">
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username') }}" placeholder="Username" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Year field --}}
        <div class="input-group mb-3">
            <select class="form-select bg-input form-control" id="floatingSelect" aria-label="Floating label select example"
                name="year">
                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
                <option value="2031">2031</option>
                <option value="2032">2032</option>
                <option value="2033">2033</option>
                <option value="2034">2034</option>
                <option value="2035">2035</option>
                <option value="2036">2036</option>
                <option value="2037">2037</option>
                <option value="2038">2038</option>
                <option value="2039">2039</option>
                <option value="2040">2040</option>
                <option value="2041">2041</option>
                <option value="2042">2042</option>
                <option value="2043">2043</option>
                <option value="2044">2044</option>
                <option value="2045">2045</option>
                <option value="2046">2046</option>
                <option value="2047">2047</option>
                <option value="2048">2048</option>
                <option value="2049">2049</option>
                <option value="2050">2050</option>
                <option value="2051">2051</option>
                <option value="2052">2052</option>
                <option value="2053">2053</option>
                <option value="2054">2054</option>
                <option value="2055">2055</option>
                <option value="2056">2056</option>
                <option value="2057">2057</option>
                <option value="2058">2058</option>
                <option value="2059">2059</option>
                <option value="2060">2060</option>
                <option value="2061">2061</option>
                <option value="2062">2062</option>
                <option value="2063">2063</option>
                <option value="2064">2064</option>
                <option value="2065">2065</option>
                <option value="2066">2066</option>
                <option value="2067">2067</option>
                <option value="2068">2068</option>
                <option value="2069">2069</option>
                <option value="2070">2070</option>
                <option value="2071">2071</option>
                <option value="2072">2072</option>
                <option value="2073">2073</option>
                <option value="2074">2074</option>
                <option value="2075">2075</option>
                <option value="2076">2076</option>
                <option value="2077">2077</option>
                <option value="2078">2078</option>
                <option value="2079">2079</option>
                <option value="2080">2080</option>
                <option value="2081">2081</option>
                <option value="2082">2082</option>
                <option value="2083">2083</option>
                <option value="2084">2084</option>
                <option value="2085">2085</option>
                <option value="2086">2086</option>
                <option value="2087">2087</option>
                <option value="2088">2088</option>
                <option value="2089">2089</option>
                <option value="2090">2090</option>
                <option value="2091">2091</option>
                <option value="2092">2092</option>
                <option value="2093">2093</option>
                <option value="2094">2094</option>
                <option value="2095">2095</option>
                <option value="2096">2096</option>
                <option value="2097">2097</option>
                <option value="2098">2098</option>
                <option value="2099">2099</option>
                <option value="2100">2100</option>
            </select>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('adminlte::adminlte.remember_me') }}
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button type=submit
                    class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>

    </form>
@stop

@section('auth_footer')
@stop
