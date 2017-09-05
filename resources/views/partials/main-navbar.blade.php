@if(Auth::user())
    <nav class = "navbar navbar-expand-lg navbar-light bg-light">
        <a href = "{{ route('home') }}" class="navbar-brand"><i class = "fa fa-home"></i> Salon Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main" aria-controls="navbar-main"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class = "collapse navbar-collapse" id = "navbar-main">
            <ul class = "navbar-nav">
                <li class = "nav-item">
                    <a class = "nav-link" href = "{{ route('payday') }}">Payday</a>
                </li>
                <li class = "nav-item dropdown">
                    <a href = "#" class = "nav-link dropdown-toggle" data-toggle = "dropdown" role = "button" id="technician-dropdown"
                       aria-haspopup="true" aria-expanded="false">Technicians </a>
                    <ul class = "dropdown-menu" aria-labelledby="technician-dropdown">
                        <a class = "dropdown-item" href = "{{ route('quick-sale-entry') }}">Quick Sale Entry</a>
                        <a class = "dropdown-item" href = "{{ route('technician-sale-add') }}">Add Technician Sale</a>
                        <a class = "dropdown-item" href = "{{ route('technician-book') }}">Book</a>
                    </ul>
                </li>
                <li class = "nav-item dropdown">
                    <a href = "#" class = "nav-link dropdown-toggle" data-toggle = "dropdown" role = "button" id="technician-dropdown"
                       aria-haspopup="true" aria-expanded="false">Salon </a>
                    <ul class = "dropdown-menu" aria-labelledby="technician-dropdown">
                        <a class = "dropdown-item" href = "{{ route('salon-sale') }}">Sale</a>
                    </ul>
                </li>
                <li class = "nav-item dropdown">
                    <a href = "#" class = "nav-link dropdown-toggle" data-toggle = "dropdown" role = "button" id="technician-dropdown"
                       aria-haspopup="true" aria-expanded="false">Reports</a>
                    <ul class = "dropdown-menu" aria-labelledby="technician-dropdown">
                        <a class = "dropdown-item" href = "{{ route('wage-report') }}">Technician Wages</a>
                        <a class = "dropdown-item" href = "{{ route('payment-reports') }}">Technician Payments</a>
                    </ul>
                </li>
                <li class = "nav-item dropdown">
                    <a href = "#" class = "nav-link dropdown-toggle" data-toggle = "dropdown" role = "button" id="technician-dropdown"
                       aria-haspopup="true" aria-expanded="false">Settings </a>
                    <ul class = "dropdown-menu" aria-labelledby="technician-dropdown">
                        <a class = "dropdown-item" href = "{{ route('api-dashboard') }}">API Dashboard</a>
                    </ul>
                </li>
            </ul>
            <ul class = "navbar-nav ml-auto">
                <li class = "nav-item ">
                    <a class = "nav-link"  href = "{{ route('logout') }}"><i class = "fa fa-sign-out"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>
@endif


