<?php
    if(empty($pagina[1]) || $pagina[1]==""){
        $pagina[1]="all";
    }

    if(empty($pagina[2]) || $pagina[2]==""){
        $pagina[2]=1;
    }

    if(empty($_SESSION["web_product_order"])){
        $_SESSION["web_product_order"]="ASC";
    }
?>
<div class="bg-white full-box">
    <div class="container container-web-page">
        <?php
            $nombre_categoria=$ins_login->datos_tabla("Unico","categoria","categoria_id",$ins_login->encryption($pagina[1]));
            
            if($pagina[1]!="all" && $nombre_categoria->rowCount()==1){
                $nombre_categoria=$nombre_categoria->fetch();
        ?>
            <h3 class="font-weight-bold poppins-regular text-uppercase"><?php echo $nombre_categoria['categoria_nombre']; ?></h3>
            <p class="text-justify"><?php echo $nombre_categoria['categoria_descripcion']; ?></p>
        <?php }else{ ?>
            <h3 class="font-weight-bold poppins-regular text-uppercase">Productos en tienda</h3>
        <?php } ?>
        <p class="text-justify">Bienvenido al menú de productos, acá encontrara todos los productos disponibles en nuestra tienda. Puede ordenar los productos por categoría en el botón "<i class="fas fa-tags fa-fw"></i> CATEGORÍAS" y también ordenarlos por orden alfabético o por precio en el botón "<i class="fas fa-sort-alpha-down fa-fw"></i> ORDENAR POR". Además, puede buscar productos por nombre haciendo clic en el botón "<i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR"</p>
        
        <div class="container-fluid" style="border-top: 1px solid #E1E1E1; padding: 20px; 0">
            <div class="row align-items-center">
                <div class="col-12 col-sm-4 text-center text-sm-start">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="categorySubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tags fa-fw"></i> &nbsp; CATEGORÍAS
                        </button>
                        <div class="dropdown-menu" aria-labelledby="categorySubMenu">
                            <a class="dropdown-item" href="<?php echo SERVERURL.$pagina[0].'/all/1/'; ?>">** Todas **</a>
                            <?php
                                $datos_categoria=$ins_login->datos_tabla("Normal","categoria WHERE categoria_estado='Habilitada'","categoria_id,categoria_nombre,categoria_estado",0);
                                while($campos_categoria=$datos_categoria->fetch()){
                                    echo '<a class="dropdown-item" href="'.SERVERURL.$pagina[0].'/'.$campos_categoria['categoria_id'].'/1/'.'">'.$campos_categoria['categoria_nombre'].'</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4 text-center">
                    <button type="button" class="btn btn-link" data-mdb-toggle="modal" data-mdb-target="#searchModal">
                        <i class="fas fa-search fa-fw"></i> &nbsp; Buscar
                    </button>
                </div>
                <div class="col-12 col-sm-4 text-center text-sm-end">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="OrderSubMenu" data-mdb-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sort-alpha-down fa-fw"></i> &nbsp; 
                            <?php
                                if($_SESSION["web_product_order"]=="ASC"){
                                    echo "Ascendente (A-Z)";
                                }elseif($_SESSION["web_product_order"]=="DESC"){
                                    echo "Descendente (Z-A)";
                                }elseif($_SESSION["web_product_order"]=="MIN"){
                                    echo "Precio (Menor a Mayor)";
                                }elseif($_SESSION["web_product_order"]=="MAX"){
                                    echo "Precio (Mayor a Menor)";
                                }
                            ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="OrderSubMenu">
                            <button class="dropdown-item" href="#" onclick="ordernar_producto('ASC')" >
                                Ascendente (A-Z)
                            </button>
                            <button class="dropdown-item" href="#" onclick="ordernar_producto('DESC')" >
                                Descendente (Z-A)
                            </button>
                            <button class="dropdown-item" href="#" onclick="ordernar_producto('MIN')" >
                                Precio (Menor a Mayor)
                            </button>
                            <button class="dropdown-item" href="#" onclick="ordernar_producto('MAX')" >
                                Precio (Mayor a Menor)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <?php
            if(isset($_SESSION[$pagina[0]]) && !empty($_SESSION[$pagina[0]])){
        ?>
        <div class="container-fluid" style="padding: 20px 0;">
            <div class="row">
                <div class="col-12 col-md-8">
                    <p class="text-left lead"><i class="fas fa-search fa-fw"></i> &nbsp; Resultados de la búsqueda: <span class="font-weight-bold poppins-regular text-uppercase"><?php echo $_SESSION[$pagina[0]]; ?></span></p>
                </div>
                <div class="col-12 col-md-4">
                    <form class="mb-4 FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="search" data-lang="<?php echo LANG; ?>" method="POST">
                        <input type="hidden" name="modulo_buscador" value="eliminar">
                        <input type="hidden" name="modulo_url" value="<?php echo $pagina[0]; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times fa-fw"></i> &nbsp; Eliminar busqueda
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            }else{
                $_SESSION[$pagina[0]]="";
            }
         
        
            require_once "./controladores/productoControlador.php";
            $ins_producto = new productoControlador();

            echo $ins_producto->cliente_paginador_producto_controlador($pagina[2],10,$pagina[0],$_SESSION["web_product_order"],$pagina[1],$_SESSION[$pagina[0]]);
        ?>
    </div>
</div>

<!-- Modal buscar producto -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true" aria-labelledby="searchModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="false" >
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" data-form="default" data-lang="<?php echo LANG; ?>" method="POST" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="searchModalLabel">Buscar producto</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="modulo_buscador" value="buscar">
                <input type="hidden" name="modulo_url" value="<?php echo $pagina[0]; ?>">

                <div class="form-outline mb-4">
                    <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="txt_buscador" id="txt_buscador" maxlength="30">
                    <label for="txt_buscador" class="form-label">¿Qué estás buscando?</label>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-mdb-dismiss="modal"><i class="fas fa-times fa-fw"></i> &nbsp; Cerrar</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function ordernar_producto(orden){

        let datos = new FormData();
        datos.append("orden", orden);
        datos.append("categoria", "<?php echo $pagina[1]; ?>");
        datos.append("modulo_producto", "producto_ordenar");

        fetch('<?php echo SERVERURL; ?>ajax/productoAjax.php',{
            method: 'POST',
            body: datos
        })
        .then(respuesta => respuesta.json())
        .then(respuesta =>{
            return alertas_ajax(respuesta);
        });
    }
</script>