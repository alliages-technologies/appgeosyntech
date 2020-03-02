    @include('head-front')

    <body data-topbar="dark" data-layout="horizontal">

        <!-- Begin page -->
        <div id="layout-wrapper">


            <header style="background-color: #28a745" id="page-topbar">
                <div style="height: 50px;" class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <div class="navbar-brand-box">
                            <a href="/" class="logo logo-dark">OBAC TRAINING CENTER</a>

                            <a href="/" style="color: #FFFFFF" class="logo logo-light">OBAC TRAINING CENTER</a>
                        </div>
                        </div>

                        <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Rechercher...">
                                <span class="mdi mdi-magnify"></span>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ml-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-search-dropdown">

                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Rechercher ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="dropdown d-inline-block">
                            <a style="height: 50px; color: #FFFFFF" href="/login"  class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <span class="d-none d-sm-inline-block ml-1">SE CONNECTER</span>
                                <i class="mdi mdi-login"></i>
                            </a>
                        </div>


                    </div>
                </div>
            </header>

            <div style="margin-top: 50px;" class="topnav">
                <div class="container-fluid">
                    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                        <div class="collapse navbar-collapse" id="topnav-menu-content">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/">
                                        <i class="mdi mdi-home mr-2"></i>ACCUEIL
                                    </a>
                                </li>

                                <li class="nav-item dropdown mega-dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-grid-large mr-2"></i>SECTEURS <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu mega-dropdown-menu" aria-labelledby="topnav-uielement">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div>
                                                    <a href="#" class="dropdown-item">FINANCES</a>
                                                    <a href="#" class="dropdown-item">COMPTABILITE</a>
                                                    <a href="#" class="dropdown-item">GESTION FINANCIERE</a>
                                                    <a href="#" class="dropdown-item">RH</a>
                                                    <a href="#" class="dropdown-item">MARKETING</a>
                                                    <a href="#" class="dropdown-item">GESTION D'ENTREPRISE</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <a href="#" class="dropdown-item">RESEAUX &amp; TELECOMS</a>
                                                    <a href="#" class="dropdown-item">PROGRAMMATION</a>
                                                    <a href="#" class="dropdown-item">INFOGRAPHIE</a>
                                                    <a href="#" class="dropdown-item">BASES DE DONNEES</a>
                                                    <a href="#" class="dropdown-item">SYSTEMES D'EXPLOITATION</a>
                                                    <a href="#" class="dropdown-item">MODELISATION</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <a href="#" class="dropdown-item">Spinner</a>
                                                    <a href="#" class="dropdown-item">Carousel</a>
                                                    <a href="#" class="dropdown-item">Video</a>
                                                    <a href="#" class="dropdown-item">Typography</a>
                                                    <a href="#" class="dropdown-item">Grid</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>

                                 <li class="nav-item">
                                    <a class="nav-link" href="/formations">
                                        <i class="mdi mdi-school mr-2"></i>TOUTES LES FORMATIONS
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="/centres">
                                        <i class="mdi mdi-houzz mr-2"></i>NOS CENTRES
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="" style="margin-top: 105px;">
                    <header>
                      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                          <!-- Slide One - Set the background image for this slide in the line below -->
                          <div class="carousel-item active" style="background-image: url('{{ asset('img/slide1.jpg') }}')">
                            <div class="carousel-caption d-none d-md-block">
                              <h3 class="display-4">PREMIERE SLIDE</h3>
                              <p class="lead">Description de la premiere slide</p>
                            </div>
                          </div>
                          <!-- Slide Two - Set the background image for this slide in the line below -->
                          <div class="carousel-item" style="background-image: url('{{ asset('img/slide2.jpg') }}')">
                            <div class="carousel-caption d-none d-md-block">
                              <h3 class="display-4">DEUXIEME SLIDE</h3>
                              <p class="lead">This is a description for the second slide.</p>
                            </div>
                          </div>
                          <!-- Slide Three - Set the background image for this slide in the line below -->
                          <div class="carousel-item" style="background-image: url('{{ asset('img/slide3.jpg') }}')">
                            <div class="carousel-caption d-none d-md-block">
                              <h3 class="display-4">TROISIEME SLIDE</h3>
                              <p class="lead">This is a description for the third slide.</p>
                            </div>
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                      </div>
                    </header>

                    <!-- Page Content -->
                    <section class="py-5">
                      <div class="container-fluid">
                        <h1 class="font-weight-light">BIENVENU SUR OBAC TRAINING CENTER - <small>Votre Plateforme de formation</small></h1>
                        <p class="lead">OBAC TRAINING CENTER est une plateforme qui gere ........ <a href="https://unsplash.com">Unsplash</a>!</p>
                      </div>
                    </section>

                    <section>
                        <div class="container-fluid">
                            <h1> DECOUVREZ NOS FORMATIONS</h1>
                            <div class="row">
                               <?php for($i=1; $i<=12; $i++): ?>
                                    <div class="col-lg-3 col-md-4">
                                        <div class="gallery-box text-center card p-2">
                                            <a href="assets/images/small/img-1.jpg" class="text-dark gallery-popup">
                                                <div class="position-relative gallery-content">
                                                    <div class="demo-img">
                                                        <img src="assets/images/small/img-1.jpg" alt="" class="img-fluid mx-auto d-block rounded">
                                                    </div>
                                                    <div class="gallery-overlay">
                                                        <div class="gallery-overlay-icon">
                                                            <i class="ti-zoom-in text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div class="overlay-content">
                                                        <h5 class="font-size-14 text-truncate mb-0">FORMATION de Rang <?= $i ?></h5>
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Amet dignissimos eligendi.
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                               <?php endfor ?>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= date('Y') ?> © OBAC TRAINING CENTER.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-right d-none d-sm-block">
                                    Conçue <i class="mdi mdi-file-code-outline text-primary"></i> par Alliages Technologies
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


    </body>
    @include('footer-front')