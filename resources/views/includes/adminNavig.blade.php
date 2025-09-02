 <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category"> Navigation </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('statistiques_SA')}}">
                    <i class="menu-icon mdi mdi-chart-line"></i>
                    <span class="menu-title"> statistiques </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('liste_paiements')}}">
                    <i class="menu-icon mdi mdi-wallet-outline"></i>
                    <span class="menu-title"> abonnements  </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('liste_utilisateurs')}}">
                    <i class="menu-icon mdi mdi-account-circle-outline"></i>
                    <span class="menu-title"> Utilisateurs </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('roles')}}">
                        <i class="menu-icon mdi mdi-shield-account"></i>
                        <span class="menu-title"> rôles </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{route('notifications_SA')}}">
                    <i class="menu-icon mdi mdi-clock"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifications_attentes ?? 0 }}
                    </span>
                    <span class="menu-title"> notifications </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{route('suggestions_SA')}}">
                    <i class="menu-icon mdi mdi-message-text-outline"></i>
                    <span class="menu-title"> suggestions </span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $suggestions_attentes ?? 0 }}
                    </span>
                    </a>
                </li>
          </ul>
        </nav>
