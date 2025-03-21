<p class="lead">
  Actualiza la información de los productos
</p>
<ul class="breadcrumb" style="margin-bottom: 5px;">
  <li>
    <a href="configAdmin.php?view=product">
      <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp; Nuevo producto
    </a>
  </li>
  <li>
    <a href="configAdmin.php?view=productlist"><i class="fa fa-list-ol" aria-hidden="true"></i> &nbsp; Productos en tienda</a>
  </li>
</ul>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="container-form-admin">
        <h3 class="text-primary text-center">Actualizar datos del producto</h3>
        <?php
        $code = $_GET['code'];
        $producto = ejecutarSQL::consultar("SELECT * FROM producto WHERE CodigoProd='$code'");
        $prod = mysqli_fetch_array($producto, MYSQLI_ASSOC);
        ?>
        <form action="./process/updateProduct.php" method="POST" enctype="multipart/form-data" class="FormCatElec" data-form="update">
          <input type="hidden" name="code-old-prod" value="<?php echo $prod['CodigoProd']; ?>">
          <div class="container-fluid">
            <div class="row">
              <div class="col-xs-12">
                <legend>Datos básicos</legend>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Código de Tienda</label>
                  <input type="text" class="form-control" value="<?php echo $prod['CodigoProd']; ?>" required maxlength="30" readonly name="prod-codigo">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Código de Producto</label>
                  <input type="text" class="form-control" value="<?php echo $prod['CodigoDeProducto']; ?>" required maxlength="30" name="prod-codigodeproducto">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Nombre de producto</label>
                  <input type="text" class="form-control" value="<?php echo $prod['NombreProd']; ?>" required maxlength="100" name="prod-name">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Marca</label>
                  <input type="text" class="form-control" value="<?php echo $prod['Marca']; ?>" required name="prod-marca">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Modelo</label>
                  <input type="text" class="form-control" value="<?php echo $prod['Modelo']; ?>" required name="prod-model">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Precio</label>
                  <input type="text" class="form-control" value="<?php echo $prod['Precio']; ?>" required maxlength="20" pattern="[0-9.]{1,20}" name="prod-price">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Descuento (%)</label>
                  <input type="text" class="form-control" required maxlength="2" pattern="[0-9]{1,2}" name="prod-desc-price" value="<?php echo $prod['Descuento']; ?>">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Unidades disponibles</label>
                  <input type="text" class="form-control" value="<?php echo $prod['Stock']; ?>" required maxlength="20" pattern="[0-9]{1,20}" name="prod-stock">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group label-floating">
                  <label class="control-label">Condición</label>
                  <input type="text" class="form-control" value="<?php echo $prod['Condicion']; ?>" required maxlength="30" name="prod-condicion">
                </div>
              </div>
              <div class="col-xs-12">
                <legend>Categoría, proveedor y estado</legend>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                  <label>Categoría</label>
                  <select class="form-control" name="prod-categoria">
                    <?php
                    $categoria = ejecutarSQL::consultar("SELECT * FROM categoria");
                    while ($catec = mysqli_fetch_array($categoria, MYSQLI_ASSOC)) {
                      if ($prod['CodigoCat'] == $catec['CodigoCat']) {
                        echo '<option selected="" value="' . $catec['CodigoCat'] . '">' . $catec['Nombre'] . ' (Actual)</option>';
                      } else {
                        echo '<option value="' . $catec['CodigoCat'] . '">' . $catec['Nombre'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                  <label>Proveedor</label>
                  <select class="form-control" name="prod-codigoP">
                    <?php
                    $proveedor = ejecutarSQL::consultar("SELECT * FROM proveedor");
                    while ($prov = mysqli_fetch_array($proveedor, MYSQLI_ASSOC)) {
                      if ($prod['NITProveedor'] == $prov['NITProveedor']) {
                        echo '<option selected="" value="' . $prov['NITProveedor'] . '">' . $prov['NombreProveedor'] . ' (Actual)</option>';
                      } else {
                        echo '<option value="' . $prov['NITProveedor'] . '">' . $prov['NombreProveedor'] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                  <label>Estado</label>
                  <select class="form-control" name="prod-estado">
                    <?php
                    if ($prod['Estado'] == "Activo") {
                      echo '
                                				<option value="Activo" selected="">Activo (Actual)</option>
                                    			<option value="Desactivado">Desactivado</option>
                                			';
                    } else {
                      echo '
                                				<option value="Activo">Activo</option>
                                    			<option value="Desactivado" selected="">Desactivado (Actual)</option>
                                			';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-12">
                <legend>Imagen/Foto del producto</legend>
                <p class="text-center text-primary">
                  No es necesario actualizar la Imagen/Foto del producto, sin embargo si desea actualizarla seleccione una en el siguiente campo. Formato de imágenes admitido png y jpg. Tamaño máximo 5MB
                </p>
              </div>
              <div class="col-xs-12">
                <div class="form-group">
                  <input type="file" name="img">
                  <div class="input-group">
                    <input type="text" readonly="" class="form-control" placeholder="Seleccione la imagen del producto...">
                    <span class="input-group-btn input-group-sm">
                      <button type="button" class="btn btn-fab btn-fab-mini">
                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                      </button>
                    </span>
                  </div>
                  <p class="help-block">Formato de imágenes admitido png y jpg. Tamaño máximo 5MB</p>
                </div>
              </div>
              <div class="col-xs-12">
                <legend>Imágenes adicionales del producto</legend>
                <p class="text-center text-primary">
                  Ingrese los enlaces de las imágenes adicionales del producto.
                </p>
              </div>
              <div class="col-xs-12">
                <div class="form-group label-floating">
                  <label class="control-label">Imagen 1 (URL)</label>
                  <input type="url" class="form-control" name="img1" value="<?php echo $prod['Imagen1']; ?>">
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group label-floating">
                  <label class="control-label">Imagen 2 (URL)</label>
                  <input type="url" class="form-control" name="img2" value="<?php echo $prod['Imagen2']; ?>">
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group label-floating">
                  <label class="control-label">Imagen 3 (URL)</label>
                  <input type="url" class="form-control" name="img3" value="<?php echo $prod['Imagen3']; ?>">
                </div>
              </div>
              <div class="col-xs-12">
                <div class="form-group label-floating">
                  <label class="control-label">Imagen 4 (URL)</label>
                  <input type="url" class="form-control" name="img4" value="<?php echo $prod['Imagen4']; ?>">
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="admin-name" value="<?php echo $_SESSION['nombreAdmin'] ?>">
          <p class="text-center"><button type="submit" class="btn btn-success btn-raised">Actualizar producto</button></p>
        </form>
      </div>
    </div>
  </div>
</div>