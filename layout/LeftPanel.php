
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="home.php"><i class="fas fa-home"></i>Inicio </a>
                </li>
                <li>
                    <a href="perfil.php"><i class="fas fa-user"></i>Perfil </a>
                </li>

        
                <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 2): ?>
                    <li>
                       
                        <a href="../vista/video.php"><i class="fas fa-film"></i>Videos </a>
                        <a href="../vista/usuario.php"><i class="fas fa-users"></i>Usuarios </a>
                        <a href="../vista/group.php"><i class="fas fa-film"></i>  Grupos de Video</a>
                        <a href="../vista/definicionea.php"><i class="fas fa-align-justify"></i>Definicion de estilos de 
                        aprendizaje</a>
                       <a href="../vista/codigoeati.php"><i class="fas fa-align-justify"></i>Codigo de TI y EA</a>
                        
                    </li>
                <?php endif; ?>



            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->
