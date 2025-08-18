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
        <div class="navbar-menu-wrapper d-flex align-items-top">  <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <?php $user =Auth::user(); ?>
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="../../assets/images/{{$user->profil}}" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="../../assets/images/{{$user->profil}}" height="45px" width="45px" alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold">{{$user->name}}</p>
                  <p class="fw-light text-muted mb-0">{{$user->email}}</p>
                </div>
                <a class="dropdown-item" href="myProfil"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Mon profil <span class="badge badge-pill badge-danger">1</span></a>
                <a class="dropdown-item" href="deconnexion"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Deconnexion </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
       <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
          </ul>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                          <h4 class="card-title card-title-dash"> Espace Boutiques </h4>
                          <p class="card-subtitle card-subtitle-dash"> managez vos boutiques  en toute aisance  </p>
                        </div>
                        <div>
                            <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p" data-bs-toggle="modal" data-bs-target="#shopModal" type="button"><i class="mdi mdi-plus"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom Boutique </th>
                            <th> Email </th>
                            <th> Telephone </th>
                            <th> Localisation </th>
                            <th> Site web </th>
                            <th> Logo</th>
                            <th> actions </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ( $inf_boutiques as $inf_store )
                                <tr>
                                    <td > {{$inf_store->nom_boutique }}</td>
                                    <td> {{$inf_store->email}} </td>
                                    <td> {{$inf_store->telephone}} </td>
                                    <td> {{$inf_store->adresse}} </td>
                                    <td> {{$inf_store->site_web}} </td>
                                    <td> <img src="{{asset('assets/images/'.$inf_store->logo)}}" alt=""> </td>
                                    <td>
                                        <button class="btn btn-secondary text-white" data-id="{{$inf_store->id}}" data-nom="{{$inf_store->nom_boutique}}" data-email="{{$inf_store->email}}" data-telephone="{{$inf_store->telephone}}" data-adresse="{{$inf_store->adresse}}" data-site_web="{{$inf_store->site_web}}" data-logo="{{$inf_store->logo}}" onclick="openEditModal(this)" > <i class="fas fa-edit"></i> </button>
                                        <button class="btn btn-danger text-white" data-id="{{$inf_store->id}}" onclick="openSuppModal(this)"> <i class="fas fa-trash"></i> </button>
                                        <a href="{{route('boutique_activation',[$inf_store->id])}}" class="btn btn-success text-white"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted"> aucune boutique crée pour le moment </td>
                            </tr>
                            @endforelse
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         @include('includes/footer')
        </div>
      </div>
    </div>

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ajouter une boutique   </h5>
                    <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('storeBoutiques')}}" enctype="multipart/form-data" id="formulaire" >
                        @csrf
                           <div class="mb-3">
                            <label for="centreName" class="form-label">Nom Boutique </label>
                            <input type="text" name="nom_boutique" class="form-control" placeholder="entrez le nom de la boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> Email Boutique </label>
                            <input type="email" name="email" class="form-control" placeholder="entrez l'email de la boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">contact Boutique </label>
                            <input type="tel" name="telephone" class="form-control" placeholder="entrez le contact de la boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">Logo Boutique </label>
                            <input type="file" name="logo" class="form-control" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">adresse Boutique </label>
                            <input type="text" name="adresse" class="form-control" placeholder="entrez la localisation de la boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">site web </label>
                            <input type="text" name="site_web" class="form-control" placeholder="entrez le site web de la boutique">
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
                    <h5 class="modal-title" id="editModalLabel"> Modifier les informations de la boutique   </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data"  action="" id="editForm" >
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="centreName" class="form-label">Nom Boutique </label>
                            <input type="text" name="nom_boutique" class="form-control" id="nom_boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label"> Email Boutique </label>
                            <input type="email" name="email" class="form-control" id="email_boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">contact Boutique </label>
                            <input type="tel" name="telephone" class="form-control" id="contact_boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">Logo Boutique </label>
                            <input type="file" name="logo" class="form-control" >
                            <img src="" height="65px" width="65px" id="logo_boutique" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">adresse Boutique </label>
                            <input type="text" name="adresse" class="form-control" id="adresse_boutique" >
                        </div>
                        <div class="mb-3">
                            <label for="centreName" class="form-label">site web </label>
                            <input type="text" name="site_web" class="form-control" id="site_web" >
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
              <h5 class="modal-title" id="deleteModalLabel">Supprimer la boutique</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir supprimer cette boutique ?
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
                    @if(session('boutique_deleted'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('boutique_deleted')}}</h5>
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
                    @if(session('success_boutique'))
                        <h5 class="text-success fw-bold mb-2">{{ session('success_boutique') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorNbModal" tabindex="-1" aria-labelledby="errorNbModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                     @if(session('error_nb'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('error_nb')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès après édition -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('boutique_update'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('boutique_update')}}</h5>
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

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
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
            var telephone = button.getAttribute('data-telephone');
            var adresse = button.getAttribute('data-adresse');
            var site_web = button.getAttribute('data-site_web');
            var logo = button.getAttribute('data-logo');
            const updateBoutiqueUrl = @json(route('update_boutique', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier un boutique ';
            document.getElementById('editForm').action = updateBoutiqueUrl.replace('__ID__', id);
            document.getElementById('nom_boutique').value = nom;
            document.getElementById('email_boutique').value = email;
            document.getElementById('contact_boutique').value = telephone;
            document.getElementById('adresse_boutique').value = adresse;
            document.getElementById('site_web').value = site_web;
            document.getElementById('logo_boutique').src = '{{ asset('assets/images/') }}/' + logo; // Update the image source
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    <script>
        const deleteBoutiqueUrl = @json(route('delete_boutiques', ['id' => '__ID__']));
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteBoutiqueUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('boutique_deleted'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('success_boutique'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('boutique_update'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('error_nb'))
            var NbModal = new bootstrap.Modal(document.getElementById('errorNbModal'));
            NbModal.show();
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

