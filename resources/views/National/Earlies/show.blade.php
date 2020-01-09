@extends('......layouts.admin')
@section('content')


<?php //dd($projet->resultats)

 ?>
 <input type="hidden" value="<?= $projet->token ?>" id="token"/>
<div class="card">
        <div class="card-header">
          <h3 class="card-title">{{$projet->name}} - {{$projet->code}} - <small><?= date_format($projet->created_at,'d/m/Y') ?></small></h3>

        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-9 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Investissement</span>
                      <span class="info-box-number text-center text-muted mb-0"><?= number_format($projet->montant_investissement,0,',','.') ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Besoin en fonds de roulement</span>
                      <span class="info-box-number text-center text-muted mb-0"><?= number_format($projet->bfr ,0,',','.') ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Cout global</span>
                      <span class="info-box-number text-center text-muted mb-0"><?= number_format(($projet->montant_investissement + $projet->bfr),0,',','.') ?> </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12">

                  <div class="card card-danger collapsed-card">
                    <div class="card-header">
                        <h5 class="card-title">Diagnostic interne</h5>

                          <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Dérouler">
                              <i class="fas fa-plus"></i></button>
                               <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Agrandir"><i class="fas fa-expand"></i>
                               </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Fermer">
                              <i class="fas fa-times"></i></button>
                          </div>
                    </div>
                    <div class="card-body">
                         <div>
                            <div class="table-responsive">
                                 <table id="risques-tab" class="table table-condensed table-hover table-bordered">
                                  <thead>
                                    <tr>
                                        <th></th>
                                        <th>Defaillances possibles</th>
                                        <th>Causes</th>
                                        <th>Consequences</th>
                                        <th>Frequence</th>
                                        <th>Gravite</th>
                                        <th>Criticite brut</th>

                                        <th>Criticite nette</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    </table>

                            </div>

                            <?php if($projet->synthese_diagnostic_interne): ?>
                                <div class="tab-pane fade" role="tabpanel" id="synthese1" aria-labelledby="">
                                    <p><?= $projet->synthese_diagnostic_interne ?></p>
                                </div>
                            <?php endif ?>
                                     </div>
                    </div>
                  </div>

                  @if($projet->etape>=2)
                    <div class="card card-primary collapsed-card">
                        <div class="card-header">
                            <h5 class="card-title">Diagnostic externe</h5>

                              <div class="card-tools">

                                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                  </button>
                                  <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Agrandir"><i class="fas fa-expand"></i>
                                  </button>

                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Fermer">
                                  <i class="fas fa-times"></i></button>
                              </div>
                        </div>
                        <div class="card-body">
                                 <ul class="nav nav-tabs" style="margin: 2px 10px 20px 0" id="objTabs" role="tablist">
                                         <li role="presentation" class="nav-item">
                                             <a class="nav-link active" href="#segments" role="tab" id="tab1" data-toggle="tab" aria-controls="n1" aria-selected="true"><span class=""></span> ANALYSE DE LA DEMANDE </a>
                                         </li>

                                         <li role="presentation" class="nav-item">
                                             <a class="nav-link" href="#concurrents" role="tab" id="tab2" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> ANALYSE DE L'OFFRE </a>
                                         </li>

                                         <li role="presentation" class="nav-item">
                                             <a class="nav-link" href="#environnement" role="tab" id="tab3" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> ANALYSE DE L'ENVIRONNMENT </a>
                                         </li>

                                         <?php if($projet->synthese_diagnostic_externe): ?>
                                            <li role="presentation" class="nav-item">
                                             <a class="nav-link" href="#synthese2" role="tab" id="tab4" data-toggle="tab" aria-controls="n2" aria-expanded="false"><span class=""></span> SYNTHESE </a>
                                         </li>
                                         <?php endif; ?>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                       <div class="tab-pane fade active show" role="tabpanel" id="segments" aria-labelledby="tab1">
                                             <div>
                                                     <div class="table-responsive">
                                                            <?php if($projet->segments): ?>

                                                            <table class="table table-bordered">

                                                                <tbody>
                                                                <?php $i=0; $quoi=""; $qui=""; $ou=""; $comment=""; $combien=""; $quand="";
                                                                $ca=""; $cv=""; $cf=""; $mb=""; $va=""; $salaires=""; $ebe=""; $pourquoi=""; $con ="";
                                                                foreach($projet->segments as $segment): ?>
                                                                    <?php
                                                                    $con = $con."<th>SEGMENT ". ++$i ."</th>";
                                                                    $quoi=$quoi."<td>".$segment->quoi."</td>";
                                                                    $qui=$qui."<td>".$segment->name."</td>";
                                                                    $quand=$quand."<td>".$segment->quand."</td>";
                                                                    $combien=$combien."<td>".$segment->combien."</td>";
                                                                    $ou=$ou."<td>".$segment->ou."</td>";
                                                                    $comment=$comment."<td>".$segment->comment."</td>";
                                                                    $pourquoi=$pourquoi."<td>".$segment->pourquoi."</td>";

                                                                    ?>
                                                                <?php endforeach; ?>
                                                                <tr><th></th><?= $con ?></tr>
                                                                <tr> <th>Qui sont les clients cibles ?</th> <?= $qui ?> </tr>
                                                                <tr><th>Quel est la problématique à laquelle ils sont confrontés? </th> <?= $quoi ?> </tr>
                                                                <tr> <th>Où achètent-ils des produits-services pour résoudre cette problématique ?</th> <?= $ou ?> </tr>
                                                                <tr> <th>A quelle fréquence achètent-ils ces produits-services ?</th> <?= $quand ?> </tr>
                                                                <tr> <th>En moyenne, à combien achètent ils ces produits-services ?</th> <?= $combien ?> </tr>
                                                                <tr> <th>Pourquoi achètent-ils ces produits-services en particulier et pas un autre ?</th> <?= $pourquoi ?> </tr>

                                                                </tbody>
                                                            </table>
                                                        <?php endif; ?>


                                                     </div>

                                             </div>

                                        </div>

                                        <div class="tab-pane fade" role="tabpanel" id="concurrents" aria-labelledby="">
                                        <?php if($projet->concurrents): ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">

                                            <tbody>
                                            <?php $i=0; $quoi=""; $qui=""; $ou=""; $comment=""; $combien=""; $quand="";
                                            $ca=""; $cv=""; $cf=""; $mb=""; $va=""; $salaires=""; $ebe=""; $fournisseur=""; $fidelisation=""; $comment=""; $communication=""; $con ="";
                                            foreach($projet->concurrents as $segment): ?>
                                                <?php
                                                $con = $con."<th>CONCURRENT ". ++$i ."</th>";
                                                $quoi=$quoi."<td>".$segment->quoi."</td>";
                                                $qui=$qui."<td>".$segment->name."</td>";
                                                $quand=$quand."<td>".$segment->quand."</td>";
                                                $combien=$combien."<td>".$segment->combien."</td>";
                                                $ou=$ou."<td>".$segment->ou."</td>";
                                                $comment=$comment."<td>".$segment->comment."</td>";
                                                $fournisseur=$fournisseur."<td>".$segment->fournisseur."</td>";
                                                $communication=$communication."<td>".$segment->communication."</td>";
                                                $fidelisation=$fidelisation."<td>".$segment->fidelisation."</td>";
                                                $ca=$ca."<td>".number_format($segment->ca,0,',','.' ) ."</td>";
                                                $cv=$cv."<td>".number_format($segment->cv,0,',','.')."</td>";
                                                $cf=$cf."<td>".number_format($segment->cf,0,',','.')."</td>";
                                                $salaires=$salaires."<td>".number_format($segment->salaires,0,',','.')."</td>";
                                                $va=$va."<td>". ($segment->ca -$segment->cf - $segment->cv )."</td>";
                                                $mb=$mb."<td>".($segment->ca - $segment->cv)."</td>";
                                                $ebe=$ebe."<td>". number_format(($segment->ca -$segment->cv - $segment->cf - $segment->salaires),0,',','.' )."</td>";
                                                ?>
                                            <?php endforeach; ?>
                                            <tr><th></th><?= $con ?></tr>
                                            <tr> <th >Qui sont vos concurrents sur le segment que vous avez ciblé?</th> <?= $qui ?> </tr>
                                           <tr><th>Quel est le produit-service proposé par vos  concurrents pour résoudre les problèmes auxquels vos clients sont confrontés? (Avantages et inconvénients)</th> <?= $quoi ?> </tr>
                                           <tr> <th>Quels sont les canaux de distribution utilisés par chaque concurrent pour acheminer le produit-service vers les clients? Canaux directs et indirects ; (Avantages et inconvénients)</th> <?= $ou ?> </tr>
                                           <tr> <th>Quels sont les canaux de communication utilisés par chaque concurrent pour faire connaitre leur produit-service ?  (Avantages et inconvénients)</th> <?= $communication?> </tr>
                                           <tr> <th>Quelle est la stratégie mise en place par les concurrents pour pousser les clients à acheter ? (Avantages et inconvénients)</th> <?= $comment ?> </tr>
                                           <tr> <th>Quelle est la stratégie mise en place par les concurrents pour fidéliser les clients ? (Avantages et inconvénients)</th> <?= $fidelisation ?> </tr>
                                           <tr> <th>Qui sont les fournisseurs de vos concurrents et donnez en une appréciation en terme de qualité/Coût/Quantité/Délai de livraison ?</th> <?= $fournisseur ?> </tr>
                                            <tr> <th>Quelle est la disponibilité des produits-services des concurrents (Saisonnière – toute l’année – dans la limite des niveaux de production) (Avantages et inconvénients)</th> <?= $quand ?> </tr>
                                             <tr> <th>Quelle est la disponibilité des produits-services des concurrents (Saisonnière – toute l’année – dans la limite des niveaux de production) (Avantages et inconvénients)</th> <?= $combien ?> </tr>
                                           <tr> <th>CA</th> <?= $ca ?> </tr>
                                           <tr> <th>Charges variables</th> <?= $cv ?> </tr>
                                           <tr> <th>Marge brute</th> <?= $mb ?> </tr>
                                           <tr> <th>Charges fixes</th> <?= $cf ?> </tr>
                                          <tr>  <th>Valeur ajoutee</th> <?= $va ?> </tr>
                                           <tr> <th>Salaires</th> <?= $salaires ?> </tr>
                                           <tr> <th>EBE</th> <?= $ebe ?> </tr>
                                            </tbody>
                                        </table>
                                            </div>
                                        <?php endif; ?>

                                        </div>

                                        <div class="tab-pane fade" role="tabpanel" id="environnement" aria-labelledby="">
                                              <?php if($projet->environnement->count()>0): ?>
                                                    <table class="table table-bordered table-condensed">
                                                        <thead>
                                                        <tr >
                                                            <th style="width: 25%"></th>
                                                            <th>OPPORTUNUITES</th>
                                                            <th>MENACES</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr id="ps">
                                                            <th style="width: 25%" >POLITIQUE SECTORIELLE</th>
                                                            <td ><?= $projet->environnement->pol_secto_op ?></td>
                                                            <td ><?= $projet->environnement->pol_secto_men ?></td>
                                                        </tr>
                                                        <tr id="cmep">
                                                            <th style="width: 25%">CADRE MACRO ECONOMIQUE DU PROJET</th>
                                                            <td ><?= $projet->environnement->cadre_macroeco_op ?></td>
                                                            <td ><?= $projet->environnement->cadre_macroeco_men ?></td>
                                                        </tr>
                                                        <tr id="asc">
                                                            <th style="width: 25%">ASPECTS SOCIO-CULTURELS</th>
                                                            <td ><?= $projet->environnement->asp_sociocult_op ?></td>
                                                            <td ><?= $projet->environnement->asp_sociocult_men ?></td>
                                                        </tr>
                                                        <tr id="et">
                                                            <th style="width: 25%">ENVIRONNEMENT TECHNOLOGIQUES</th>
                                                            <td ><?= $projet->environnement->env_tech_op ?></td>
                                                            <td ><?= $projet->environnement->env_tech_men ?></td>
                                                        </tr>
                                                        <tr id="iep">
                                                            <th style="width: 25%">IMPACT ENVIRONNEMENTAL DU PROJET</th>
                                                            <td ><?= $projet->environnement->impact_env_op ?></td>
                                                            <td ><?= $projet->environnement->impact_env_men ?></td>
                                                        </tr>
                                                        <tr id="crp">
                                                            <th style="width: 25%">CADRE REGLEMENTAIRE DU PROJET</th>
                                                            <td ><?= $projet->environnement->cadre_regl_op ?></td>
                                                            <td ><?= $projet->environnement->cadre_regl_men ?></td>
                                                        </tr>
                                                        <tr id="pnf">
                                                            <th style="width: 25%">POUVOIR DE NEGOCIATION DES FOURNISSEURS</th>
                                                            <td ><?= $projet->environnement->pouv_nego_frn_op ?></td>
                                                            <td ><?= $projet->environnement->pouv_nego_frn_men ?></td>
                                                        </tr>
                                                        <tr id="pnc">
                                                            <th style="width: 25%">POUVOIR DE NEGOCIATION DES CLIENTS</th>
                                                            <td ><?= $projet->environnement->pouv_nego_cli_op ?></td>
                                                            <td ><?= $projet->environnement->pouv_nego_cli_men ?></td>
                                                        </tr>
                                                        <tr id="pps">
                                                            <th style="width: 25%">PERFORMANCES  DES PRODUITS DE SUBSTITUTION </th>
                                                            <td ><?= $projet->environnement->perf_prdt_subst_op ?></td>
                                                            <td ><?= $projet->environnement->perf_prdt_subst_men ?></td>
                                                        </tr>
                                                        <tr id="ic">
                                                            <th style="width: 25%">INTENSITE CONCURRENTIELLE</th>
                                                            <td ><?= $projet->environnement->intensite_concu_op ?></td>
                                                            <td ><?= $projet->environnement->intensite_concu_men ?></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                              <?php endif; ?>
                                        </div>

                                        <?php if($projet->synthese_diagnostic_externe): ?>
                                            <div class="tab-pane fade" role="tabpanel" id="synthese2" aria-labelledby="">
                                                <br/>
                                                <br/>
                                                <p><?= $projet->synthese_diagnostic_externe ?></p>
                                            </div>

                                        <?php endif; ?>
                                     </div>

                        </div>
                    </div>

                  @endif


                  @if($projet->etape>=3)
                    <div class="card card-info collapsed-card">
                        <div class="card-header">
                            <h5 class="card-title">Diagnostic stratégique</h5>

                              <div class="card-tools">

                                  <button title="dérouler" data-toggle="tooltip" type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                  </button>
                                  <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Agrandir"><i class="fas fa-expand"></i>
                                  </button>

                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Fermer">
                                  <i class="fas fa-times"></i></button>
                              </div>
                        </div>
                        <div class="card-body">

                           <ul class="nav nav-tabs"  id="objTabs" role="tablist">
                                <li role="presentation" class="nav-item">
                                    <a class="nav-link active" href="#swot" role="tab" id="tab1" data-toggle="tab" aria-controls="n1" aria-selected="true"><span class=""></span> SWOT </a>
                                </li>

                                <li role="presentation" class="nav-item">
                                    <a class="nav-link" href="#objectifs" role="tab" id="tab2" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> OBJECTIFS </a>
                                </li>

                                <li role="presentation" class="nav-item">
                                    <a class="nav-link" href="#organisation" role="tab" id="tab3" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> ORGANISATION DU TRAVAIL </a>
                                </li>

                                <li role="presentation" class="nav-item">
                                     <a class="nav-link" href="#actions" role="tab" id="tab4" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> ACTIONS DE MAITRISE </a>
                                </li>

                                <li role="presentation" class="nav-item">
                                    <a class="nav-link" href="#etapes" role="tab" id="tab5" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> PLAN D'ACTION STRATEGIQUE </a>
                                </li>

                                <li role="presentation" class="nav-item">
                                    <a class="nav-link" href="#faisabilite" role="tab" id="tab6" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> ETUDE DE FAISABILITE</a>
                                </li>
                           </ul>

                           <div class="tab-content" id="myTabContent">
                             <div class="tab-pane fade active show" role="tabpanel" id="swot" aria-labelledby="tab1">
                                  <div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                        @if($projet->swot)
                                            <fieldset>
                                                <legend>SYNTHESE DES OPPORTUNITES</legend>
                                                <?= $projet->swot->synt_op ?>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset>
                                                <legend>SYNTHESE DES MENACES</legend>
                                                    <?= $projet->swot->synt_men ?>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset>
                                                <legend>SYNTHESE DES FORCES</legend>
                                                <?= $projet->swot->synt_forces ?>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <fieldset>
                                                <legend>SYNTHESE DES FAIBLESSES</legend>
                                                    <?= $projet->swot->synt_faiblesses ?>
                                            </fieldset>
                                            @endif
                                        </div>

                                    </div>

                                  </div>

                             </div>

                             <div class="tab-pane fade" role="tabpanel" id="objectifs" aria-labelledby="">
                                <p></p>
                                <br/>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="well">
                                            <fieldset>
                                                <legend>OBJECTIFS A COURT TERME</legend>
                                                <p><?= $projet->objectifs_courts ?></p>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="well">
                                            <fieldset>
                                                <legend>OBJECTIFS A MOYEN TERME</legend>
                                                <p><?= $projet->objectifs_moyens ?></p>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="well">
                                            <fieldset>
                                                <legend>OBJECTIFS A LONG TERME</legend>
                                                <p><?= $projet->objectifs_longs ?></p>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                             </div>

                             <div class="tab-pane fade" role="tabpanel" id="organisation" aria-labelledby="">
                                <p></p>

                                <h6 class="page-header">ORGANISATION DU TRAVAIL</h6>
                                <table class="table table-bordered table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>NOM</th>
                                            <th>FONCTION</th>
                                            <th>RESPONSABILITES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projet->ressources as $ressource)
                                            <tr>
                                                <td><?= $ressource->name ?></td>
                                                <td><?= $ressource->fonction ?></td>
                                                <td><?= $ressource->responsabilite ?></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             </div>

                             <div class="tab-pane fade" role="tabpanel" id="actions" aria-labelledby="">
                                <input type="hidden" id="plan_id" value="<?= $projet->plan_id ?>"/>
                                <table class="table table-bordered table-condensed table-hover" id="example">
                                    <thead>
                                    <tr>
                                        <th>TYPE DE RISQUE</th>
                                        <th>PRODUIT</th>
                                        <th>DEFAILLANCE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                             </div>

                             <div class="tab-pane fade" role="tabpanel" id="etapes" aria-labelledby="">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>ETAPE</th>
                                            <th>ACTION STRATEGIQUE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projet->etapes as $etape)
                                            <tr>
                                                <td>{{ $etape->name }}</td>
                                                <td>{{ $etape->action }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             </div>

                             <div class="tab-pane fade" role="tabpanel" id="faisabilite" aria-labelledby="">
                                <br/>
                                <br/>
                                <div class="well">
                                    <p><?= $projet->etude_faisabilite ?></p>
                                </div>

                             </div>


                          </div>

                      </div>
                    </div>
                        <script>
                $(document).ready(function(){
                    getPlan($('#plan_id').val());
                });
            </script>

                  @endif

                  @if($projet->etape>=4)
                    <div class="card card-default collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">PLAN FINANCIER</h3>

                              <div class="card-tools">

                                  <button title="dérouler" data-toggle="tooltip" type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                  </button>
                                  <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Agrandir"><i class="fas fa-expand"></i>
                                  </button>
                              </div>
                        </div>
                        <div class="card-body">

                            <div class="card">
                                <div class="card-header d-flex p-0">
                                    <ul class="nav nav-pills ml-auto p-2 pull-right"  role="tablist">
                                        <li role="presentation" class="nav-item">
                                            <a class="nav-link active" href="#prevresultats" role="tab" id="tab1" data-toggle="tab" aria-controls="n1" aria-selected="true"><span class=""></span> COMPTE d'EXPLOITATION </a>
                                        </li>

                                        <li role="presentation" class="nav-item">
                                            <a class="nav-link" href="#prevbilans" role="tab" id="tab2" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> BILAN </a>
                                        </li>

                                        <li role="presentation" class="nav-item">
                                            <a class="nav-link" href="#prevtresoreries" role="tab" id="tab3" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> FLUX DE TRESORERIE  </a>
                                        </li>

                                        <li role="presentation" class="nav-item">
                                             <a class="nav-link" href="#montage" role="tab" id="tab4" data-toggle="tab" aria-controls="n2" aria-selected="false"><span class=""></span> MONTAGE FINANCIER </a>
                                        </li>
                                   </ul>
                                </div>
                                <div class="card-body">
                                    <div  class="tab-content">
                                        <div class="tab-pane active" role="tabpanel" id="prevresultats" aria-labelledby="tab1">
                                      <div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>COMPTE DE RESULTAT</h4>
                                                     </div>
                                                     <div class="card-body">
                                                        <?php $nbsim = count($projet->prevresultats) ?>
                                                        <table class="table table-bordered table-hover table-condensed">
                                                        <thead>
                                                            <tr>
                                                                    <th></th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->annee ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>VARIATION</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>CHIFFRE D'AFFAIRE</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->ca ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>PRODUCTION IMMOBILISEE</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->pi ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>PRODUCTION STOCKEE</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->ps ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>SUBVENTION D'AEXPLOITATION</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->sp ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>AUTRES PRODUITS D'EXPLOITATION</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->ape ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>CHARGE VARIABLE</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->cv ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>MARGE BRUTE</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->mb ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>CHARGE FIXE</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->cf ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>VALEUR AJOUTEE</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->va ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>SALAIRES</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->ca ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>EXCEDENT BRUT D'EXPLOITATION</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->ebe ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>DOTATATION AUX AMORTISSEMENTS ET AUX PROVISIONS</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->dap ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT D'EXPLOITATION</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->re ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>PRODUIT FINANCIER</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->pf ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>CHARGES FINANCIERES</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->cfi ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT FINANCIER</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->rf ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>PRODUIT EXCEPTIONNEL</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->pe ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>CHARGES EXCEPTIONNELLES</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->ce ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT EXCEPTIONNEL</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->re ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT COURANT AVANT IMPOT</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->rcai ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <td>IMPOTS</td>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <td><?= $prevr->impots ?></td>
                                                                    @if(!$loop->last)
                                                                    <td>-</td>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                            <tr>
                                                                <th>RESULTAT NET</th>
                                                                @foreach($projet->prevresultats as $prevr)
                                                                    <th><?= $prevr->rn ?></th>
                                                                    @if(!$loop->last)
                                                                    <th>-</th>
                                                                    @endif
                                                                @endforeach
                                                            </tr>
                                                        </tbody>
                                                        </table>
                                                     </div>
                                                </div>

                                            </div>

                                        </div>

                                      </div>

                                 </div>

                                 <div class="tab-pane fade" role="tabpanel" id="prevbilans" aria-labelledby="">
                                    <p></p>
                                    <br/>
                                    <hr/>
                                    <h3>BILAN</h3>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                                 <table class="table table-bordered table-hover table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="3"></th>

                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <th><?= $prevr->annee ?></th>
                                                                        @if(!$loop->last)
                                                                        <th>VARIATION</th>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                <th style="text-orientation: upright; writing-mode: vertical-rl;" rowspan="14">RESOURCES STABLES</th>
                                                                </tr>
                                                                <tr>

                                                                    <td colspan="2">CAPITAL</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->capital ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>

                                                                    <td colspan="2">APPORTEURS DE CAPITAL NON APPELE</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->apporteurs_acpital_non_appele ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>

                                                                    <td colspan="2">PRIMES D'APPORT D'EMISSION</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->primes_apport ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>

                                                                    <td colspan="2">ECARTS DE REEVALUTATION</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->ecarts_reevaluation ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Réserves indisponibles</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->eserves_indisponibles ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Réserves libres</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->reserves_libres ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Report à nouveau</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->report_a_nouveau ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Résultat net de l'exercice</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->resultat_net_exercice ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Subventions d'investissement</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->subventions_investissement ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Provisions réglementés</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->provisions_reglementees ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">EMPRUNTS</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->emprunts ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Dettes de location acquisition</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->dettes_location_acquisition ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Provisions financières pour risques et charges</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->provisions_financieres_risques_ ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>


                                                                <tr><th style="writing-mode: vertical-rl" rowspan="16">ACTIF IMMOBILISE</th></tr>
                                                                <tr><th style="writing-mode: vertical-rl" rowspan="5">Immos incorporelles</th></tr>
                                                                <tr>

                                                                    <td>Frais de développement et de prospection</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->frais_developpement ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>

                                                                    <td>Brevets, licences, logiciels, et droits assimilaires</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->brevets ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>

                                                                    <td>Fonds commercial et droit au bail</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->fonds_commercial ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Autres immobilisations incorporelles</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->autres_immobilisations_incorporelles ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>



                                                                <tr><td style="writing-mode: vertical-rl" rowspan="7">Immos corporelles</td></tr>

                                                                <tr>
                                                                    <td>Terrains</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->terrains ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Bâtiments</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->batiments ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>

                                                                <tr>
                                                                    <td>Aménagements, agencements et installations</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->amenagements ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Matériel, mobilier et actifs biologiques</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->materiel_mobilier ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Matériel de transport</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->materiel_transport ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Avances et acomptes versés sur immobilisations</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->avances_acomptes ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>


                                                                <tr><td style="writing-mode: vertical-rl" rowspan="3">Immos fin.</td></tr>

                                                                <tr>
                                                                    <td>Titres de participation</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-model="Prevbilan" data-name="titres_participation" data-id="<?= $prevr->id ?>" ><?= $prevr->titres_participation ?><span style="display: none; cursor: pointer;" class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Autres immobilisations financieres</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->autres_immobilisations_financieres ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center" colspan="3">FONDS DE ROULEMENT</th>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <th><?= $prevr->fr ?></th>
                                                                        @if(!$loop->last)
                                                                        <th>-</th>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>

                                                                <tr><td style="writing-mode: vertical-rl" rowspan="7">ACTIF CIRCULANT</td></tr>

                                                                <tr>
                                                                    <td colspan="2">Actif circulant HAO</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->actif_circulant_hao ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Stocks et encours</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->stocks_encours ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="2">CRÉANCES ET EMPLOIS ASSIMILÉS</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->creances_emplois ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Fournisseurs avances versées</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->avances_fournisseurs ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Clients</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->clients ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Autres créances</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->autres_creances ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>


                                                                <tr><td style="writing-mode: vertical-rl" rowspan="6">PASSIF CIRCULANT</td></tr>

                                                                <tr>
                                                                    <td colspan="2">Dettes circulants HAO</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->dettes_circulantes_hao ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Clients avances reçues</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->clients_avances_recues ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="2">Fournisseurs d'exploitation</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->fournisseurs_exploitation ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Dettes fiscales et sociales</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->dettes_fiscales ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Autres dettes</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td><?= $prevr->autres_dettes ?></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center" colspan="3">BESOIN EN FONDS DE ROULEMENT</th>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <th><?= $prevr->bfr ?></th>
                                                                        @if(!$loop->last)
                                                                        <th>-</th>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr><td style="writing-mode: vertical-rl" rowspan="4">Tresorerie Active</td></tr>

                                                                <tr>
                                                                    <td colspan="2">Titres de placement</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="titres_placement" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->titres_placement ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Valeurs à encaisser</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="valeur_encaisser" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->valeur_encaisser ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Banques, chèques postaux, caisse et assimilés</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="banques_cheques_" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->banques_cheques_ ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr><td style="writing-mode: vertical-rl" rowspan="3">Tresorerie Passive</td></tr>
                                                                <tr>
                                                                    <td colspan="2">Banques, crédits d'escomptes et de trésorerie</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="banques_credit_escompte" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->banques_credit_escompte ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Banques, crédits de trésorerie</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="banques_credit_tresorerie" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->banques_credit_tresorerie ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <th style="text-align: center" colspan="3">TRESORERIE NETTE</th>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <th><?= $prevr->tn ?></th>
                                                                        @if(!$loop->last)
                                                                        <th>-</th>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" style="text-align: center">Ecart de conversion - actif</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="ecart_conversion_actif" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->ecart_conversion_actif ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3" style="text-align: center">Ecart de conversion - passif</td>
                                                                    @foreach($projet->prevbilans as $prevr)
                                                                        <td class="td-modif" data-name="ecart_conversion_passif" data-id="<?= $prevr->id ?>" data-model="Prevbilan"><?= $prevr->ecart_conversion_passif ?><span class="fa fa-pencil fa-modif"></span></td>
                                                                        @if(!$loop->last)
                                                                        <td>-</td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>

                                                            </tbody>
                                                    </table>

                                        </div>

                                    </div>

                                 </div>

                                 <div class="tab-pane fade" role="tabpanel" id="prevtresoreries" aria-labelledby="">
                                    <p></p>

                                    <h6 class="page-header">FLUX DE TRESORERIE PREVISIONNELS</h6>

                                 </div>

                                 <div class="tab-pane fade" role="tabpanel" id="montage" aria-labelledby="">
                                    <h6 class="page-header">MONTAGE FINANCIER</h6>
                                 </div>

                              </div>
                                </div>
                            </div>

                         </div>
                    </div>
                  @endif

                </div>
              </div>
            </div>
            <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2">
              <div style="max-height: 240px; max-width: 300px">
                  @if($projet->imageUri)
                      <img class="img-thumbnail" src="{{asset('img/'.$projet->imageUri)}}" alt=""/>
                      <a data-toggle="modal" data-target="#uploadImgModal" href="" title="modifier l'image"><i class="fa fa-pencil"></i></a>
                  @else
                       <img class="img-thumbnail" src="{{asset('img/logo-obac.png')}}" alt=""/>
                       <a data-toggle="modal" data-target="#uploadImgModal" href="" title="modifier l'image"><i class="fa fa-pencil"></i></a>
                  @endif
              </div>
              <h3 class="text-primary"> {{$projet->name}}</h3>
              @if($projet->modele)
                <button data-target="#meModal" data-toggle="modal" class="btn btn-sm btn-block btn-outline-success">Modèle économique</button>
              @endif
              <br>
              <div class="text-muted">
                <p class="text-sm">Porteur de projet:
                  <b class="d-block">{{$projet->owner->name}}</b>
                  <b class="d-block"><i class="far fa-fw fa-envelope"></i> {{$projet->owner->email}}</b>
                  <b class="d-block"><i class="far fa-fw fa-telegram"></i> {{$projet->owner->phone}}</b>
                </p>
                <p class="text-sm">Consultant
                   @if($projet->consultant)
                   </p>
                   <p class="text-sm">
                   <b class="d-block">{{$projet->consultant->name}}</b>
                       <b class="d-block"><i class="far fa-fw fa-envelope"></i> {{$projet->consultant->email}}</b>
                   </p>
                   @else
                                <form class="form-inline"  action="/admin/projet/expert">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{ $projet->id }}"/>
                                    <div class="form-group">
                                        <select class="form-control" name="expert_id" id="id">
                                            @foreach($experts as $expert)
                                                <option value="{{ $expert->id }}">{{ $expert->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-link"></i> LIER</button>
                                    </div>
                                </form>

                     @endif
              </div>


            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>

    @if($projet->modele)
        <style>
            #meModal .card-title{
                font-weight: 800;
                font-size: 0.9rem;
            }
        </style>
        <div class="modal fade" id="meModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel">
        		<div class="modal-dialog modal-xl" role="document">
        			<div class="modal-content">
        				<div class="modal-header bg-success">
        					<h5 style="text-transform: uppercase; background-color: transparent" class="modal-title" id="myModalLabel"><span>MODELE ECONOMIQUE</span></h5>
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
        				</div>
        				<div class="modal-body">

        				    <div class="card">
        				        <div class="card-header">


                                      <div class="card-tools">

                                           <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Agrandir"><i class="fas fa-expand"></i>
                                           </button>

                                      </div>
                                </div>
        				        <div class="card-body">
        				            <div class="row">
        				                <div class="col-md-2 col-sm-12">
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">PARTENAIRES</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->partenaires ?>
        				                        </div>
        				                    </div>
        				                </div>
        				                <div class="col-md-3 col-sm-12">
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">ACTIVITES</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->activites ?>
        				                        </div>
        				                    </div>
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">RESSOURCES</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->ressources ?>
        				                        </div>
        				                    </div>
        				                </div>
        				                <div class="col-md-2 col-sm-12">
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">OFFRE</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->offre ?>
        				                        </div>
        				                    </div>
        				                </div>
        				                <div class="col-md-3 col-sm-12">
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">RELATION CLIENT</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->relation ?>
        				                        </div>
        				                    </div>
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">CANAUX DE DISTRIBUTION</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->canaux ?>
        				                        </div>
        				                    </div>
        				                </div>
        				                <div class="col-md-2 col-sm-12">
        				                    <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">SEGMENTS CLIENT</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->segment ?>
        				                        </div>
        				                    </div>
        				                </div>
        				            </div>
        				            <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">STRUCTURE DES COUTS</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->couts ?>
        				                        </div>
        				                    </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="card">
        				                        <div class="card-header">
        				                            <h3 class="card-title">SOURCES DE REVENUS</h3>
        				                        </div>
        				                        <div class="card-body">
        				                            <?= $projet->modele->revenus ?>
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
     @endif



     <script type="text/javascript" src="{{ asset('js/api.js') }}"></script>
    <script>
        $(document).ready(function(){
           // var orm = 'http://localhost/ormsys/api/';
            $.ajax({
                url: "/admin/projet/getchoices",
                type:'Get',
                dataType:'json',
                data:{id:$('#token').val()},
                success:function(data){
                    if(data!=null){
                        $.ajax({
                            url:orm+'carto',
                            type:'Post',
                            dataType:'json',
                            data:{choix:data},
                            success:function(rep){
                                $('#risks-loader').hide();

                                var html = '';
                                //console.log(Object.entries(rep));
                                var risks=Object.entries(rep);
                                for(var i=0; i<risks.length;i++){

                                    var rs= parseInt(risks[i][1].length) + 1;
                                    var tr= '<tr><th style="align-content: center; margin-top: auto" align="center" rowspan='+ rs  +'>'+ risks[i][0] +'</th></tr>';
                                    html=html+tr;
                                    for(var k=0; k<risks[i][1].length; k++){
                                        $value = risks[i][1][k];
                                        $cb= parseInt($value.question.produits_risque.frequence) * parseInt($value.question.produits_risque.gravite);
                                        $cn=parseInt($value.question.produits_risque.frequence) * parseInt($value.question.produits_risque.gravite) * parseFloat($value.taux);

                                        if(parseFloat($cb) >= 13){
                                            $clrb='red';
                                        }else{
                                            if( parseFloat($cb) >=4 && parseFloat($cb) <= 12){
                                                $clrb='yellow';
                                            }else{
                                                $clrb = '#0ac60a';
                                            }
                                        }

                                        if( parseFloat($cn) >= 13){
                                            $clr='red';
                                        }else{
                                            if( parseFloat($cn) >=4 &&  parseFloat($cn) <= 12){
                                                $clr='yellow';
                                            }else{
                                                $clr = '#0ac60a';
                                            }
                                        }

                                        var trr = '<tr>'+
                                            '<td>'+ $value.question.produits_risque.name +'</td>'+
                                            '<td>'+$value.question.produits_risque.causes +'</td>'+
                                            '<td>'+ $value.question.produits_risque.consequences +'</td>'+
                                            '<td>'+ $value.question.produits_risque.frequence +'</td>'+
                                            '<td>'+ $value.question.produits_risque.gravite+'</td>'+
                                            '<td style="background-color:'+ $clrb +'; font-weight: 900; text-align: right">'+ $cb  +'</td>'+
                                            '<td style="background-color:'+ $clr +'">'+ $cn +'</td>'+
                                        '</tr>';

                                        html=html+trr;

                                        console.log(risks[i][1][k]);
                                    }
                                    console.log(risks[i][1]);

                                }

                                $('#risques-tab').find('tbody').html(html);
                            },
                            Error:function(){
                                $('#risks-loader').hide();
                            }
                        });
                    }

                }
            })
        });

        function getPlan(id){

                         $.ajax({
                           url:orm+'get-plan',
                           type:'Get',
                           dataType:'json',
                           data:{id:id},
                               success:function(data){
                                   //console.log(data);
                                   if(data!=null){
                                        $.ajax({
                                          url:orm+'get-plan',
                                          type:'Get',
                                          dataType:'json',
                                          data:{id:id},
                                        success:function(){
                                        }
                                        });
                                   }
                                   var html = '';
                                   var pls = data.plignes;
                                   for(var i = 0; i<data.plignes.length; i++){

                                        var tr ='<tr data-id="'+ pls[i].id +'"><td style="width: 13%">'+ pls[i].produits_risque.risque.name +'</td><td style="width: 20%">'+ pls[i].produits_risque.produit.name +'</td><td style="width: 20%">'+ pls[i].produits_risque.name +'</td><td contenteditable="true" style="width: 37%">'+ pls[i].amelioration +'</td></tr>';
                                        html = html + tr;
                                   }
                                   $('#example').find('tbody').html(html);
                               },
                           Error:function(){

                           }
                         });
                    }
    </script>

@endsection

@section('nav_actions')
<main>
    <nav class="floating-menu">
        <ul class="main-menu">

            @if($projet->investissements->count()>=1)
                   <li>
                        <a data-target="#angelsModal" data-toggle="modal" title="Liste des investisseurs potentiels" class="ripple" href="#"><i class="fa fa-users"></i></a>
                   </li>
            @endif
            @if($projet->etape==1 && $projet->validated_step==0 && $projet->modepaiement_id>0)
                   <li>
                        <a  title="Valider le premier paiement" class="ripple" href="/admin/projet/validate-diag-interne/{{ $projet->token }}"><i class="fa fa-coins"></i></a>
                   </li>
            @endif
            @if($projet->etape==2 && $projet->validated_step<2 )
                   <li>
                        <a  title="Valider le deuxieme paiement" class="ripple" href="/admin/projet/validate-diag-externe/{{ $projet->token }}"><i class="fa fa-coins"></i></a>
                   </li>
            @endif
            @if($projet->etape==3 && $projet->validated_step<3 )
                   <li>
                        <a  title="Valider le troisieme paiement" class="ripple" href="/admin/projet/validate-plan-strategique/{{ $projet->token }}"><i class="fa fa-coins"></i></a>
                   </li>
            @endif
            @if($projet->etape==4 && $projet->validated_step<4 )
                   <li>
                        <a  title="Valider le quatrieme paiement" class="ripple" href="/admin/projet/validate-plan-financier/{{ $projet->token }}"><i class="fa fa-coins"></i></a>
                   </li>
            @endif

             @if($projet->etape==4 && $projet->validated_step>=4 )
                @if($projet->ordrevirement_validated)
                   <li>
                        <a  title="Rejeter l'ordre de virement" class="ripple" href="/admin/projet/disvalidate-ordre-virement/{{ $projet->token }}"><i class="fa fa-trash"></i></a>
                   </li>
                 @else
                   <li>
                        <a  title="Valider l'ordre de virement" class="ripple" href="/admin/projet/validate-ordre-virement/{{ $projet->token }}"><i class="fa fa-check"></i></a>
                   </li>
                 @endif
            @endif

            @if($projet->active )
                   <li>
                        <a  title="Bloquer le dossier" class="ripple" href="/admin/projet/disable/{{ $projet->token }}"><i class="fa fa-lock"></i></a>
                   </li>
             @else
                    <li>
                        <a  title="debloquer le dossier" class="ripple" href="/admin/projet/enable/{{ $projet->token }}"><i class="fa fa-unlock"></i></a>
                   </li>
            @endif





        </ul>
        <div class="menu-bg"></div>
    </nav>
</main>

<div class="modal fade" id="angelsModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6  class="modal-title text-center">INVESTISSEURS POTENTIELS</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body">
            <div class="card card-danger">
                <div class="card-body">
                     @if(count($projet->investissements)>=1)
                        <table style="color: #000" id="table-invest" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 5%;"></th>
                              <th>#</th>
                              <th>Entreprise</th>
                              <th>Organisme Fin.</th>
                              <th>Depuis le</th>
                              <th>RDV</th>

                              <th style="width: 10%;"></th>

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($projet->investissements as $invest)
                                    <tr>
                                         <td style="width: 5%;"></td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#angelMoal">
                                                <img style="border-radius: 50%;float: left;height: 40px;width: 40px;"
                                                    src="{{ $invest->angel->imageUri?asset('img/'.$invest->angel->imageUri):asset('img/avatar.png') }}" /> <br/>
                                               <p>{{ $invest->angel->name }}  </p>
                                        </a>
                                        </td>
                                        <td>
                                            <?php if($invest->angel->entreprise): ?>
                                                    <img  style="border-radius: 50%;float: left;height: 40px;width: 40px;" src="{{ $invest->angel->entreprise->imageUri?asset('img/'.$invest->angel->entreprise->imageUri):asset('img/logo-obac.png') }}" /> <br/>
                                                    <p>{{ $invest->angel->entreprise->name }}</p>

                                             <?php else: ?>
                                                -
                                             <?php endif; ?>
                                        </td>
                                         <td>
                                            <?php if($invest->angel->organisme): ?>
                                                    <img  style="border-radius: 50%;float: left;height: 40px;width: 40px;" src="{{ $invest->angel->organisme->imageUri?asset('img/'.$invest->angel->organisme->imageUri):asset('img/logo-obac.png') }}" /> <br/>
                                                    <p>{{ $invest->angel->organisme->name }}</p>

                                             <?php else: ?>
                                                -
                                             <?php endif; ?>
                                        </td>
                                        <td><?= $invest->created_at?date_format($invest->created_at, 'd/m/Y'):'-' ?></td>
                                        <td><?= \Illuminate\Support\Carbon::createFromTimeString($invest->rencontre)->format('d/m/Y'); ?></td>

                                        <td style="width: 10%;">

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default btn-flat">Actions</button>
                                                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                                  <span class="caret"></span>

                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                 <?php if($invest->lettre): ?>
                                                    <a class="dropdown-item" href="/admin/letter/create/{{ $invest->token }}">Lettre d'intention</a>
                                                  <?php endif; ?>
                                                  <?php if(!$invest->doc_juridique): ?>
                                                    <a title="Autoriser l'accès à la documentation juridique" class="dropdown-item" href="/admin/projet/docs/open/{{ $invest->token }}">Ouvrir la documentation</a>
                                                  <?php else: ?>
                                                    <a title="Autoriser l'accès à la documentation juridique" class="dropdown-item" href="/admin/projet/docs/close/{{ $invest->token }}">Fermer la documentation</a>
                                                  <?php endif; ?>
                                                  <?php if($invest->validated): ?>
                                                    <a class="dropdown-item" href="/owner/investissements/close/{{ $invest->token }}">Fermer la data room</a>
                                                  <?php else: ?>
                                                    <a class="dropdown-item" href="/owner/investissements/open/{{ $invest->token }}">Ouvrir la data room</a>
                                                  <?php endif; ?>

                                                </div>
                                              </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<style>
    td p {
       border-radius: .3rem;
       color:#444;

       position: relative;
       font-weight: bold;
       display:inline-block;
       font-size: smaller;
    }
</style>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
  $(function () {
    $("#table-invest").DataTable({
        "lengthChange":true

    });

  });
</script>

@endsection
