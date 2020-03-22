@extends('......layouts.admin')

@section('page-title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">POSTES</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">SGN</a></li>
                        <li class="breadcrumb-item active">Postes</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')

          <div class="container">
                <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">LISTE DES POSTES <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target="#modal-lg"><i class="fa fa-plus-circle"></i></a></h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-hover table-condensed datatable">
                    <thead>
                    <tr>
                      <th>NOM</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($postes as $ville)
                          <tr>
                              <td>{!! $ville->name !!} </td>



                          </tr>
                      @endforeach

                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
              </div>

            </div>

            <!-- /.col -->
          </div>
          </div>

           <div class="modal fade" id="modal-lg">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">NOUVEAU POSTE</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form  method="post">
                        {{csrf_field()}}

                          <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                      <label for="name">NOM</label>
                                      <input type="text" class="form-control" id="name" name="name" placeholder="Saisir le nom du poste">
                                    </div>
                                </div>

                                <div class="form-group">
                                <fieldset>
                                    <legend>SECTEURS ASSOCIES</legend>
                                    <ul class="list-inline">
                                        <?php foreach($secteurs as $secteur): ?>
                                            <li class="list-inline-item">
                                                <div class="form-group">
                                                    <label for="">
                                                        <input class="secteur_id" data-id="{{$secteur->id}}" name="{{ $secteur->id }}" type="checkbox"/>
                                                        <span>{{ $secteur->name }}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </fieldset>
                                </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                          <div class="card-footer">
                            <button id="btn-save" type="submit" class="btn btn-success btn-block"><i class="fa fa-w fa-save"></i> Enregistrer</button>
                          </div>
                        </form>
                      </div>

                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
           </div>


<style>
    .table th,
    .table td {
      padding: 0.35rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }
  </style>



@endsection

@section('scripts')
    <script>
            $('#btn-save').click(function(e){
                //console.log('ok');
                e.preventDefault();
                var data = [];
                data.push({name:$('#name').val()});
                var secteurs = [];
                $('.secteur_id').each(function(){
                   secteurs.push($(this).data('id'))
                });
                data.push(data);

                 $.ajax({
                     url:'/admin/post',
                     dataType:'json',
                     type:'get',
                     data:data,
                     success:function(dt){
                         window.location.href='/admin/postes';
                     }
                 });


            })
      </script>
@endsection