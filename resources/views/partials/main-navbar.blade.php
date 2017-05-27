@if(Auth::user())
    <nav class = "navbar navbar-default navbar-static-top navbar-custom" role = "navigation">
        <div class = "container-fluid">
            <div class = "navbar-header">
                <a href = "{{ route('home') }}" class = "navbar-brand"><i class = "fa fa-home"></i> Sugar Nails</a>
                <button class = "navbar-toggle" type = "button" data-toggle = "collapse" data-target = "#navbar-main">
                    <span class = "icon-bar"></span>
                    <span class = "icon-bar"></span>
                    <span class = "icon-bar"></span>
                </button>
            </div>
            <div class = "navbar-collapse collapse" id = "navbar-main">
                <ul class = "nav navbar-nav">
                    <li><a href = "{{ route('payday') }}"><i class = "fa fa-dollar"></i> Payday</a></li>
                    <li class = "dropdown">
                        <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown" role = "button"><i class = "fa fa-users"></i> Technicians <span class = "caret"></span></a>
                        <ul class = "dropdown-menu" role = "menu">
                            <li><a href = "{{ route('technician-sale') }}">Sales</a></li>
                            <li><a href = "{{ route('technician-book') }}">Book</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class = "nav navbar-nav navbar-right">
                    <li class = "dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class = "fa fa-user fa-lg"></i> {{Auth::user()->name}} <span class="caret"></span>
                        </a>
                        <ul class = "dropdown-menu" role = "menu">
                            <li><a href = "{{ route('logout') }}"><i class = "fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif

