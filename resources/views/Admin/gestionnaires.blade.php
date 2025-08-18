<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES STOCK </title>
    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo"  href="">
              <img src="{{asset('assets/images/logo.svg')}}" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="">
              <img src="{{asset('assets/images/logo-mini.svg')}}" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav ms-auto">
            <?php $user = Auth::user(); ?>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="{{asset('assets/images/'.$user->profil)}}" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" height="45px" height="45px" src="{{asset('assets/images/'.$user->profil)}}
                  " alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold">{{$user->name}}</p>
                  <p class="fw-light text-muted mb-0">{{$user->email}}</p>
                  <p class="fw-light text-muted mb-0"> {{$boutique_nom}}</p>
                </div>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Mon Profil <span class="badge badge-pill badge-danger">1</span></a>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Deconnexion</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">
        @include('includes/nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash"> Espace Employés  </h4>
                        <p class="card-subtitle card-subtitle-dash">managez vos employés en toute aisance</p>
                      </div>
                      <div>
                        <button class="btn btn-primary btn-lg text-white mb-0 me-0" data-bs-toggle="modal" data-bs-target="#shopModal" type="button"><i class="mdi mdi-plus"></i></button>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom  </th>
                            <th> Email  </th>
                            <th> Adresse </th>
                            <th> Telephone </th>
                            <th> poste </th>
                            <th> profil </th>
                            <th> connecté(e) ?</th>
                            <th> Piece identité </th>
                            <th colspan="2"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($gestionnaires as $gest  )
                                <tr>
                                    <td>{{$gest->name}}</td>
                                    <td>{{$gest->email}}</td>
                                    <td>{{$gest->adresse}}</td>
                                    <td>{{$gest->contact }}</td>
                                    <td> {{$gest->role}}</td>
                                    <td><img src="{{asset('assets/images/'.$gest->profil)}}" alt=""></td>
                                    @if ($gest->status_connexion)
                                        <td class="text-success fw-bold">
                                            <label class="badge badge-success">✔ Connecté</label>
                                        </td>
                                    @else
                                        <td class="text-danger fw-bold">
                                            <label class="badge badge-danger"> ✖ Non connecté </label>
                                        </td>
                                    @endif
                                    <td>
                                        <img src="{{asset('assets/images/'.$gest->piece_identite)}}" alt="">
                                    </td>
                                    <td>
                                            <button type="button" class="btn btn-success" data-id="{{$gest->id}}" data-role="{{$gest->role}}" data-nom="{{$gest->name}}" data-email="{{$gest->email}}" data-contact="{{$gest->contact}}" data-adresse="{{$gest->adresse}}" data-profil="{{$gest->profil}}" data-piece_identite="{{$gest->piece_identite}}" onclick="openEditModal(this)"> Modifier</button>
                                            <button type="button" class="btn btn-danger" data-id="{{$gest->id}}" onclick="openSuppModal(this)"> Supprimer </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Aucun employé enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                      </table>
                      <div class="mt-3 d-flex justify-content-center">
                        {{ $gestionnaires->links('pagination::bootstrap-5') }}
                     </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('includes.footer')
        </div>
      </div>
    </div>

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ajouter une employé   </h5>
                    <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('add_gestionnaires')}}" enctype="multipart/form-data" id="formulaireGestionnaires" >
                        @csrf
                            <div class="mb-3">
                                <label for="centreName" class="form-label">Nom Employé </label>
                                <input type="text" name="name" class="form-control" id="" placeholder="entrer le nom de l'employe ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> adresse </label>
                                <input type="text" name="adresse" class="form-control" id="" placeholder="entrer la localisation de votre employé ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> contact </label>
                                <input type="tel" name="contact" class="form-control" id="" placeholder="entrer un contact de l'employé valide ">
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label">Email </label>
                                <input type="email" name="email" placeholder="entrez une adresse email de l'employe valide " class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> Image employe </label>
                                <input type="file" name="profil"  class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> Image Piece d'identite </label>
                                <input type="file" name="piece_identite"  class="form-control" >
                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> Role de l'employé </label>
                                <select name="role" id="categorie_produit" class="form-select">
                                    <option value="" selected disabled>— Sélectionnez une catégorie —</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->nom }}">{{ $rol->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="button-container">
                            <button type="submit" id="bouton" class="button btn btn-success" > enregistrer </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> Modifier les informations des employes   </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data"  action="" id="editForm" >
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="centreName" class="form-label">Nom Employé </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="entrer le nom de l'employe ">
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> adresse </label>
                            <input type="text" name="adresse" class="form-control" id="adresse" placeholder="entrer la localisation de votre employé ">
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> contact </label>
                            <input type="tel" name="contact" class="form-control" id="contact" placeholder="entrer un contact de l'employé valide ">
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">Email </label>
                            <input type="email" name="email" placeholder="entrez une adresse email de l'employe valide " id="email" class="form-control" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> Image employe </label>
                            <input type="file" name="profil" id="" class="form-control" >
                            <img src="profil" id="profil" width="65px" height="65px" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> Image Piece d'identite </label>
                            <input type="file" name="piece_identite" class="form-control" >
                            <img src=""  id="piece_identite" height="65px" width="65px" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> Role de l'employé </label>
                            <select name="role" id="categorie_produit" class="form-select">
                                <option value="" selected disabled>— Sélectionnez un role —</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->nom }}">{{ $rol->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="button-container ">
                            <button type="submit" id="bouton" class="button btn btn-success" > Modifier </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Fermer </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Supprimer l'employé </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir supprimer cet employé ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
              <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Oui</button>
              </form>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('delete_employes'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('delete_employes')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


        <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('gestionnaires_creation'))
                        <h5 class="text-success fw-bold mb-2">{{ session('gestionnaires_creation') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                <div class="spinner-border text-primary" role="status"></div>
                </div>
                <h6 class="text-primary fw-bold">Veuillez patienter...</h6>
            </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('gestionnaires_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('gestionnaires_updated')}}</h5>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-danger shadow-lg">
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                        </div>
                        <h5 class="text-danger fw-bold mb-3">Erreur(s) détectée(s)</h5>
                        <ul class="text-start text-danger small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.j')}}s"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>

    <script>
        function openEditModal(button) {

            var id = button.getAttribute('data-id');
            var nom = button.getAttribute('data-nom');
            var email = button.getAttribute('data-email');
            var adresse = button.getAttribute('data-adresse');
            var role = button.getAttribute('data-role');
            var telephone = button.getAttribute('data-contact');
            var profil = button.getAttribute('data-profil');
            var piece_identite = button.getAttribute('data-piece_identite');
            const updateEmployesUrl = @json(route('update_employes', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier un employes ';
            document.getElementById('editForm').action = updateEmployesUrl.replace('__ID__', id);
            document.getElementById('name').value = nom;
            document.getElementById('contact').value = telephone;
            document.getElementById('adresse').value = adresse;
            document.getElementById('email').value = email;
            document.getElementById('role').value = role;
            document.getElementById('piece_identite').src = 'assets/images/' + piece_identite;
            document.getElementById('profil').src = 'assets/images/' + profil;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    <script>

        const deleteEmployesUrl =@json(route('delete_employes', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteEmployesUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('delete_employes'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("#formulaireGestionnaires");
            if (form) {
                form.addEventListener("submit", function () {
                    // Affiche le modal de chargement
                    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
                    loadingModal.show();
                });
            }

            // Affiche le modal de succès si une session existe
            @if(session('gestionnaires_creation'))
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            @endif
        });

    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('gestionnaires_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif


  </body>
</html>
