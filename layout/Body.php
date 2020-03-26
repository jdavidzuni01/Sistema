<body>
        <!-- Left Panel -->
        <?php
        include_once('../layout/LeftPanel.php');
        ?>
        <!-- /#left-panel -->

        <div id="right-panel" class="right-panel">


            <header id="header" class="header">
                <div class="top-left">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#"><img src="../images/logo.png" alt="Logo"></a>
                        <a class="navbar-brand hidden" href="#"><img src="../images/logo2.png" alt="Logo"></a>
                        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>                
                <div class="top-right">
                    <div class="header-menu">
                        <div class="header-left">
                            <button class="search-trigger"><i class="fa fa-search"></i></button>
                            <div class="form-inline">
                                <form class="search-form" method="get" action="../vista/resultados.php">
                                    <input class="form-control" type="text" placeholder="Search ..." aria-label="Search" name="buscar">
                                    <button class="d-none" name="pagina" value="1" type="submit"><i class="fa fa-search"></i></button>     
                                    <button class="search-close"><i class="fa fa-close"></i></button>
                                </form>
                            </div>

                      

                        <div class="user-area dropdown float-right">
                            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if (isset($_SESSION["foto"]) && $_SESSION["foto"] != "0") { ?>
                                <img class="user-avatar rounded-circle" src="<?php echo  $_SESSION["foto"]; ?>" >
                                <?php } ?>

                                <?php if (isset($_SESSION["foto"]) && $_SESSION["foto"] == "0") { ?>
                                    <img class="user-avatar rounded-circle" src="../images/user.png" >
                                <?php } ?>


                            </a>

                            <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="../vista/perfil.php"><i class="fa fa-user"></i><?php
                                    if (isset($_SESSION["usuario"])) {
                                        echo $_SESSION["usuario"];
                                    }
                                    ?></a>
                          
                                <a class="nav-link" data-toggle="modal" data-target="#exampleModal" href="#"><i class="fa fa-power-off"></i>Salir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header><!-- /header -->