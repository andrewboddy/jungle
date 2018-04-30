<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <image src="/images/jungle.png" height="70" width="120"/>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;<li> <a href="/indicators">Indicators</a></li>
                &nbsp;<li> <a href="/dashboard">Dashboard</a></li>
                &nbsp;<li> <a href="/watchitems">Watchlist</a></li>
                &nbsp;<li> <a href="/positions">Positions</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Stocks <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/stocks">Stocks by Industry</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Reports</li>
                        <li><a href="/stocksByGrowth">Highest Growth</a></li>
                        <li><a href="/stocksByF1estimates">F1 Estimates</a></li>
                        <li><a href="/stocksBySurprise">Earnings Surprise</a></li>
                        <li><a href="/stocksByQestimates">Q Estimates</a></li>
                    </ul>
                </li>
                &nbsp;<li> <a href="/admin">Administration</a></li>
                &nbsp;<li> <a href="/research">Research</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
