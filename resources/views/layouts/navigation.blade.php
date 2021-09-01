<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
        @role('administrator')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('students.index') }}">{{ __('Mahasiswa') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('faculties.index') }}">{{ __('Fakultas') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('program-studies.index') }}">{{ __('Program Studi') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('school-years.index') }}">{{ __('Tahun Ajaran') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('courses.index') }}">{{ __('Mata Kuliah') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('study-plan-cards.index') }}">{{ __('KRS') }}</a>
        </li>
        @elserole('mahasiswa')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">{{ __('Profil') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('study-plan-mahasiswa.index') }}">{{ __('KRS') }}</a>
        </li>
        @endrole

    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>
