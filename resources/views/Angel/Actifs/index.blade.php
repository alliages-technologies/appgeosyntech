@extends('layouts.angel')



@section('content')
    <div style="padding-top: 30px" class="container-fluid">

                <div class="row">
                    <?php $i=0; $colors=['danger','info','warning','primary','success'] ?>

                    @foreach($dossiers as $projet)


                     <div class="col-md-3 col-sm-12">


                    <!-- small card -->
                    <div class="small-box bg-{{ $colors[$i] }}">
                    <?php $i==5?$i=0:$i++ ?>
                      <div class="inner">
                        <h3>{{ $projet->prix }}<sup style="font-size: 20px">{{ $projet->devise->abb }}</sup></h3>

                        <p>{{ $projet->name }}</p>
                        <img src="{{ $projet->imageUri?asset('img/'.$projet->imageUri):asset('img/logo.png') }}" style="width: 100px; height: 100px; border-radius: 50px; position: absolute; top:15px; right: 10px"/>
                      </div>

                      <a data-target="#viewModal" data-toggle="modal" href="#" class="small-box-footer btn-p">
                        Je suis intéressé(e) <i class="fas fa-arrow-circle-right"></i>
                      </a>
                    </div>

                        <div style="display: none" id="teaser-{{$projet->token}}">
                            <input type="hidden" name="token" value="<?= $projet->token ?>"/>
                            <?php if($projet->teaser): ?>
                            <div>
                                <p>{{ $projet->teaser }}</p>
                            <?php endif; ?>
                        </div>

                    </div>

                    @endforeach



                </div>
            </div>
<div  class="modal fade" id="viewModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-success">
                <h4  class="modal-title project-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <form enctype="multipart/form-data" class="form" action="/angel/investissements/" method="post">
                    {{csrf_field()}}

                    <div class="">
                            <div class="stepwizard">
                                <div class="stepwizard-row setup-panel">
                                    <div class="stepwizard-step">
                                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                                        <p>AVERTISSEMENT</p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                                        <p>RESUME EXECUTIF</p>
                                    </div>
                                    <div class="stepwizard-step">
                                        <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                                        <p>RENCONTRE</p>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="">

                                    <div class="setup-content" id="step-1">
                                        <div class="alert alert-warning">

                                           <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                           Investir dans un actif est une prise de risque. <br> Nous recommandons aux investisseurs d’appliquer des règles de vigilance avant tout investissement : l'investissement dans des actifs comporte des risques de perte totale ou partielle du montant investi, risque d'illiquidité et risque opérationnel du projet pouvant entraîner une rentabilité moindre que prévue.
                                            N’investissez pas dans ce que vous ne comprenez pas parfaitement.
                                         </div>
                                         <div class="btn-div card-footer text-center">
                                                <button class="btn btn-primary prevBtn btn-sm  btn-rounded" type="button"> <i class="fa fa-arrow-left"></i> PRECEDENT</button>
                                                <button class="btn btn-primary nextBtn btn-sm  btn-rounded" type="button"> SUIVANT <i class="fa fa-arrow-right"></i></button>
                                            </div>
                                    </div>

                                     <div class="setup-content" id="step-2">
                                        <div class="card">

                                            <div class="card-body">
                                               <div id="teaser-content"></div>
                                            </div>
                                            <div class="btn-div card-footer text-center">
                                                <button class="btn btn-primary prevBtn btn-sm  btn-rounded" type="button"> <i class="fa fa-arrow-left"></i> PRECEDENT</button>
                                                <button class="btn btn-primary nextBtn btn-sm  btn-rounded" type="button"> SUIVANT <i class="fa fa-arrow-right"></i></button>
                                            </div>
                                        </div>

                                     </div>
                                     <div class="setup-content" id="step-3">
                                        <div class="card">
                                            <div class="card-header">
                                                 <h4>PROGRAMMER UNE RENCONTRE AVEC LE PORTEUR DE PROJET</h4>
                                            </div>
                                            <div class="card-body">
                                                <input type="date" name="dt_rdv" class="form-control"/>
                                            </div>
                                            <div class="btn-div card-footer text-center">
                                                <button class="btn btn-primary prevBtn btn-sm  btn-rounded" type="button"> <i class="fa fa-arrow-left"></i> PRECEDENT</button>
                                               <button id="btn-save" class="btn btn-success btn-sm"><i class="fa fa-save"></i> ENREGISTRER</button>
                                            </div>
                                        </div>
                                     </div>

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
        $('.btn-p').click(function(e){
            e.preventDefault();
            $('.project-title').text($(this).data('name'));
            var token = $(this).data('token');
            var teaser = $('#teaser-'+token).html();
            $('#teaser-content').html(teaser);
        });
    </script>
@endsection

