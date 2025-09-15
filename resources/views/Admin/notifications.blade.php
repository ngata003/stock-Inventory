<!DOCTYPE html>
<html lang="en">
  <head>
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
    <link rel="stylesheet" href="{{asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/js/select.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .fixed-height-card {
            height: 400px;        /* hauteur fixe */
            overflow-y: auto;     /* scroll si le contenu dépasse */
            height: 300px;        /* hauteur fixe */
        }
    </style>

  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
       @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
       @include('includes.nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                      <div class="row">
                        <div class="col-lg-7 d-flex flex-column">
                            <div class="row flex-grow">
                                <div class="col-12 col-lg-12 grid-margin stretch-card">
                                    <div class="card card-rounded">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Notifications</h4>
                                                </div>
                                                <div class="d-flex justify-content-end mb-3 gap-2">
                                                    <div class="dropdown ms-2">
                                                        <button class="btn btn-primary dropdown-toggle" type="button" id="categoryDropdown"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            Choisir un mois
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                                            @for ($i = 1; $i <= 12; $i++)
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('notifications', ['mois' => $i]) }}">
                                                                        {{ \Carbon\Carbon::create()->month($i)->locale('fr')->monthName }}
                                                                    </a>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Description</th>
                                                            <th>Date</th>
                                                            <th>Statut</th>
                                                            <th> Actions </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($notifications as $notif )
                                                            <tr>
                                                                <td>{{$notif->id}}</td>
                                                                <td>{{$notif->description}}</td>
                                                                <td>{{$notif->created_at->format('d-m-y')}}</td>
                                                                <td id="notif-{{ $notif->id }}">
                                                                        @if ($notif->status === "lu")
                                                                            <button class="btn btn-success btn-sm">
                                                                                <span style="color: white">Déjà lu</span>
                                                                            </button>
                                                                        @elseif ($notif->status === "attente")
                                                                            <button class="btn btn-primary btn-sm" onclick="showNotif({{ $notif->id }})">
                                                                                <span style="color: white">Nouveau message</span>
                                                                            </button>
                                                                        @endif
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-id="{{$notif->id}}" onclick="openSuppModal(this)">
                                                                        <i class="mdi mdi-trash-can-outline text-white"></i>
                                                                    </button>
                                                                    <button class="btn btn-success btn-sm" onclick="showNotif({{ $notif->id }})">
                                                                        <i class="mdi mdi-eye text-white"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">Aucune notification enregistrée</td>
                                                        </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                    <div class="mt-3 d-flex justify-content-center">
                                                        {{ $notifications->links('pagination::bootstrap-5') }}
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lecture notifications -->
                        <div class="col-lg-5 d-flex flex-column" id="lecture-notif">
                            <div class="row flex-grow">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card card-rounded fixed-height-card">
                                        <div class="card-body">
                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="card-title card-title-dash">Lecture des notifications</h4>
                                                </div>
                                            </div>
                                            <div id="placeholder" class="text-muted">
                                            </div>
                                            <div class="mt-4" id="notif-content" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('notification_deleted'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('notification_deleted')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    <h5 class="text-danger fw-bold mb-3"> Supprimer la notification ?</h5>
                    <p class="text-muted mb-3">Êtes-vous sûr de vouloir supprimer cette notification ?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Non</button>
                        <form method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Oui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script src="{{asset('assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <script>
       function showNotif(id) {
            let bloc = document.getElementById('lecture-notif');
            bloc.classList.remove('d-none');

            fetch(`/notifications_message/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Afficher le contenu du message
                    document.getElementById('notif-content').innerHTML = `
                        <p><strong>Message :</strong> ${data.message}</p>
                    `;

                    // Décrémenter le badge
                    let badge = document.querySelector('.badge.bg-danger');
                    if (badge) {
                        let count = parseInt(badge.innerText);
                        if (count > 0) {
                            badge.innerText = count - 1;
                            if (count - 1 === 0) {
                                badge.style.display = "none"; // cacher si 0
                            }
                        }
                    }

                    // Mettre à jour le bouton dans le tableau
                    let td = document.getElementById(`notif-${id}`);
                    if (td) {
                        td.innerHTML = `
                            <button class="btn btn-success btn-sm">
                                <span style="color: white">Déjà lu</span>
                            </button>
                        `;
                    }
                })
                .catch(error => {
                    console.error("Erreur :", error);
                    document.getElementById('notif-content').innerHTML =
                        `<p class="text-danger">Impossible de charger la notification.</p>`;
                });
        }

    </script>

    <script>
        const deleteNotificationsUrl =@json(route('delete_notifications_admin', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteNotificationsUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('notification_deleted'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>
  </body>
</html>
