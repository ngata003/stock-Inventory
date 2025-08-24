      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo"  href="">
              <img src="{{asset('assets/images/cames_stock.png')}}" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="">
              <img src="{{asset('assets/images/cames_stock.png')}}" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <?php $user = Auth::user() ; ?>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="{{asset('assets/images/'.$user->profil)}}" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" width="55px" height="55px" src="{{asset('assets/images/'.$user->profil)}}" alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold">{{$user->name}}</p>
                  <p class="fw-light text-muted mb-0">{{$user->email}}</p>
                  <p class="fw-light text-muted mb-0"> {{$boutique_nom}}</p>
                </div>
                <a class="dropdown-item" href="{{route('profil')}}"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Mon Profil </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center" style="background: none; border: none; width: 100%;">
                        <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Déconnexion
                    </button>
                </form>

              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
