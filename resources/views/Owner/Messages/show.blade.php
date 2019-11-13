@extends('......layouts.owner')


@section('content')



<section style="padding: 20px;" class="content">

      <div class="row">
        <div class="col-md-3">
          <a href="#" data-toggle="modal" data-target="#composeModal" class="btn btn-outline-danger btn-block mb-3">Composer</a>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Repertoires</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="#" class="nav-link">
                    <i class="fas fa-inbox"></i> Boîte de reception
                    <span class="badge bg-primary float-right">{{ $receptions->where('lu',0)->count() }}</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-envelope"></i> Envois
                  </a>
                </li>


                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Corbeille
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Sujets</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle text-danger"></i>
                    Recherche de financements
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle text-warning"></i> Cessions d'actifs
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle text-primary"></i>
                    Concessions
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">{{ $message->expediteur->name }} - <b> {{ $message->investissement->projet->name }} <small> {{ $message->subject }}</small> </b> </h3>

              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">

                <div class="mailbox-read-info">
                <h5><b> {{ $message->investissement->projet->name }} <small> {{ $message->subject }}</small> </b></h5>
                <h6>De: {{ $message->expediteur->name }} - {{ $message->expediteur->email }}
                  <span class="mailbox-read-time float-right">{{ date_format($message->created_at, 'd/m/Y H:i') }}</span></h6>
              </div>

              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                    <i class="far fa-trash-alt"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                    <i class="fas fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                    <i class="fas fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                  <i class="fas fa-print"></i></button>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                 <?= $message->body ?>
              </div>
              <!-- /.mailbox-read-message -->

            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

</section>

<div class="modal fade" id="composeModal">
   <div class="modal-dialog modal-lg">
     <div class="modal-content">
       <div class="modal-header bg-success">
         <h4 class="modal-title">NOUVEAU MESSAGE</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <form enctype="multipart/form-data" role="form" action="{{route('owner.mailbox.store')}}" method="post">
         {{csrf_field()}}

           <div class="card">
                <div class="card-body">

                <div class="form-group">
                <label for="">DESTINATAIRE</label>
                <select name="receptor_id" class="form-control" id="receptor_id">
                    <option value="0">CHOIX DU DESTINAIRE</option>
                    @foreach($angels as $angel)
                        <option value="{{ $angel->id }}">{{ $angel->name  }} - <small>{{ $angel->email }}</small></option>
                    @endforeach
                </select>

                </div>
                <div class="form-group">
                    <label for="">Projet</label>
                    <select name="investissement_id"  class="form-control" id="investissement_id">

                    </select>
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Objet:">
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea"  cols="30" style="height: 300px"></textarea>
                </div>


                <button type="submit" class="btn btn-outline-success btn-block"><i class="fa fa-w fa-save"></i> Enregistrer</button>
                </div>
           </div>

         </form>
       </div>

     </div>
     <!-- /.modal-content -->
   </div>
       <!-- /.modal-dialog -->
</div>

<script>
	$("#receptor_id").on('change',function(){
		// console.log($("#sector_id").val());
		var url = '/owner/mails/get-investissements';
		$.ajax({
			url:url,
			type:'get',
			dataType:'Json',
			data:{ id:$("#receptor_id").val()},

			success: function(data){
				$("#investissement_id").html("");
				var option = '';
				var dat =data.investissements;
				console.log(dat);

				for(var i=0; i<dat.length;i++ ){
					option=option+'<option value='+ dat[i].id +'>'+ dat[i].projet.name +'</option>';
					$("#investissement_id").html(option);
					console.log(option);
				}

			}
		});
	});
</script>




    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}"/>
    <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>


   <!-- Page Script -->
   <script>
     $(function () {
       //Add text editor
       $('#compose-textarea').summernote({
             height: 300
       })
     })
   </script>


<!-- AdminLTE for demo purposes -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<!-- jQuery -->

<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}} "></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>

<script>
  $(function () {

    $('#table-mgs').DataTable({
      "paging": true,
      "lengthChange": false,

      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

@endsection