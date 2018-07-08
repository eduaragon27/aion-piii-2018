<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENÚ PRINCIPAL</li>
            <?php
                /*Crear la variable POST para enviarle al controlador*/
                $_POST["codigo_cargo"] = $s_codigoCargo;
                /*Crear la variable POST para enviarle al controlador*/

                require_once '../controlador/obtener.opciones.menu.controller.php';
                
                //print_r($resultadoOpcionesMenuBD);
                
                for ($i = 0; $i < count( $resultadoOpcionesMenuBD ); $i++) {
                    echo '<li class="treeview">';
                        echo '<a href="#">';
                            echo '<i class="fa fa-laptop"></i>';
                            echo '<span>'.$resultadoOpcionesMenuBD[$i]["nombre"].'</span>';
                            echo '<span class="pull-right-container">';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                            echo '</span>';
                        echo '</a>';
                        
                        /*Mostrar los items a los que tiene acceso el usuario*/
                        echo '<ul class="treeview-menu">';
                        
                        
                        /*Crear la variable POST para enviarle al controlador*/
                        $_POST["codigo_menu"] = $resultadoOpcionesMenuBD[$i]["codigo_menu"];
                        //echo $_POST["codigo_menu"];
                        /*Crear la variable POST para enviarle al controlador*/
                        
                        require '../controlador/obtener.opciones.menu.item.controller.php';
                        
                        for ($j = 0; $j < count($resultadoOpcionesMenuItemBD); $j++) {
                            echo '<li><a href="'.$resultadoOpcionesMenuItemBD[$j]["archivo"].'"><i class="fa fa-circle-o"></i> '. $resultadoOpcionesMenuItemBD[$j]["nombre"] .'</a></li>';
                        }
                        echo '</ul>';
                        /*Mostrar los items a los que tiene acceso el usuario*/
                        
                    echo '</li>';
                }
            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>