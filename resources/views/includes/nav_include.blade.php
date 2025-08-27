        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-category"> Navigation </li>
            @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('statistiques')}}">
                    <i class="menu-icon mdi mdi-chart-line"></i>
                    <span class="menu-title"> statistiques </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('mes_paiements')}}">
                    <i class="menu-icon mdi mdi-wallet-outline"></i>
                    <span class="menu-title"> mes paiements </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('clients')}}">
                    <i class="menu-icon mdi mdi-account-tie-outline"></i>
                    <span class="menu-title"> clients </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('gestionnaires')}}">
                    <i class="menu-icon mdi mdi-account-circle-outline"></i>
                    <span class="menu-title"> Employes  </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('gestionnaires')}}">
                    <i class="menu-icon mdi mdi-bell-outline"></i>
                    <span class="menu-title"> Notifications  </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('suggestions')}}">
                    <i class="menu-icon mdi mdi-message-text-outline"></i>
                    <span class="menu-title"> Suggestions  </span>
                    </a>
                </li>
            @endif

            @if (in_array(Auth::user()->role, ['admin', 'employe']))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('categories')}}">
                    <i class=" menu-icon mdi mdi-tag-multiple-outline"></i>
                    <span class="menu-title"> categories produits </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('coursiers')}}">
                    <i class="menu-icon mdi mdi-truck"></i>
                    <span class="menu-title"> coursiers </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                        <i class="menu-icon mdi mdi-package-variant"></i>
                        <span class="menu-title">Produits</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('produits')}}"> produits</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('fournisseurs')}}"> fournisseurs </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('approvisionnement')}}">approvisionnement</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                        <i class="menu-icon mdi mdi-cart-outline"></i>
                        <span class="menu-title">ventes</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{route('ventes')}}"> Vendre </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('liste_ventes')}}"> liste des ventes </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('commandes')}}"> commander </a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('liste_commandes')}}"> liste des commandes  </a></li>
                        </ul>
                    </div>
                </li>
            @endif
          </ul>
        </nav>
