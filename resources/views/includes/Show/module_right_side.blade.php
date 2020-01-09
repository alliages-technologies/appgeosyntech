<link href="{{ asset('css/video-js.css') }}" rel="stylesheet">
<div class="card">
    <div>
        <ul class="list" style="list-style-type: none">

            @foreach($module->cours as $cour)
                <li style="margin-top: 10px">
                    <div class="card">

                        <div class="card-body">
                             <h4 style="padding: 5px; margin-bottom: 5px; border-bottom: 1px solid darkcyan; font-weight: 700; font-family: Helvetica;" >{{ $cour->name }} </h4>
                             <div class="row">
                                <div class="col-md-6 col-sm-12">


                                        @if($cour->videoUri)

                                            <video  id="example_video_1" style="width: 99%; height: 200px" class="video-js vjs-default-skin vjs-big-play-centered"
                                                       controls preload="auto">
                                                    <source src="{{url('/load-video/'.$cour->videoUri)}}" />
                                            </video>

                                        @endif



                                </div>

                                <div class="col-md-6 col-sm-12">
                                        @if($cour->description)
                                        <h5>Description</h5>
                                        <p><?= $cour->description ?></p>
                                        @endif
                                        @if($cour->audioUri)
                                           <p><audio controls style="width: 200px;" > <source src="{{ asset('podcasts/'.$cour->audioUri) }}" type="audio/mpeg"></audio></p>
                                        @endif
                                        @if($cour->pdfUri)
                                          <p>  <a href="/read-pdf/{{ $cour->pdfUri }}"><i class="fa fa-file-pdf"></i> Consulter le fichier</a> </p>
                                        @endif

                                </div>
                             </div>

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>