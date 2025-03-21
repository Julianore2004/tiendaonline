<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';

$codeOldProdUp = consultasSQL::clean_string($_POST['code-old-prod']);
$codigoDeProductoUp = consultasSQL::clean_string($_POST['prod-codigodeproducto']);
$nameProdUp = consultasSQL::clean_string($_POST['prod-name']);
$catProdUp = consultasSQL::clean_string($_POST['prod-categoria']);
$priceProdUp = consultasSQL::clean_string($_POST['prod-price']);
$modelProdUp = consultasSQL::clean_string($_POST['prod-model']);
$marcaProdUp = consultasSQL::clean_string($_POST['prod-marca']);
$stockProdUp = consultasSQL::clean_string($_POST['prod-stock']);
$proveProdUp = consultasSQL::clean_string($_POST['prod-codigoP']);
$EstadoProdUp = consultasSQL::clean_string($_POST['prod-estado']);
$condicionProdUp = consultasSQL::clean_string($_POST['prod-condicion']);
$descProdUp = consultasSQL::clean_string($_POST['prod-desc-price']);

$imgName = $_FILES['img']['name'];
$imgType = $_FILES['img']['type'];
$imgSize = $_FILES['img']['size'];
$imgMaxSize = 5120;
$imgFinalName = '';

// Obtener la ruta de la imagen actual
$currentProduct = ejecutarSQL::consultar("SELECT Imagen FROM producto WHERE CodigoProd='$codeOldProdUp'");
$currentImg = mysqli_fetch_array($currentProduct, MYSQLI_ASSOC)['Imagen'];

if ($imgName != "") {
    if ($imgType == "image/jpeg" || $imgType == "image/png") {
        if (($imgSize / 1024) <= $imgMaxSize) {
            chmod('../assets/img-products/', 0777);
            switch ($imgType) {
                case 'image/jpeg':
                    $imgEx = ".jpg";
                    break;
                case 'image/png':
                    $imgEx = ".png";
                    break;
            }
            $imgFinalName = $codeOldProdUp . $imgEx;
            if (move_uploaded_file($_FILES['img']['tmp_name'], "../assets/img-products/" . $imgFinalName)) {
                // Eliminar la imagen anterior si existe
                if ($currentImg && file_exists("../assets/img-products/" . $currentImg)) {
                    unlink("../assets/img-products/" . $currentImg);
                }
            } else {
                echo '<script>swal("ERROR", "Ha ocurrido un error al cargar la imagen", "error");</script>';
                exit();
            }
        } else {
            echo '<script>swal("ERROR", "Ha excedido el tamaño máximo de la imagen, tamaño máximo es de 5MB", "error");</script>';
            exit();
        }
    } else {
        echo '<script>swal("ERROR", "El formato de la imagen del producto es invalido, solo se admiten archivos con la extensión .jpg y .png ", "error");</script>';
        exit();
    }
}

$img1 = consultasSQL::clean_string($_POST['img1']);
$img2 = consultasSQL::clean_string($_POST['img2']);
$img3 = consultasSQL::clean_string($_POST['img3']);
$img4 = consultasSQL::clean_string($_POST['img4']);

$updateQuery = "NombreProd='$nameProdUp',CodigoCat='$catProdUp',Precio='$priceProdUp',Descuento='$descProdUp',Modelo='$modelProdUp',Marca='$marcaProdUp',Stock='$stockProdUp',NITProveedor='$proveProdUp',Estado='$EstadoProdUp',Condicion='$condicionProdUp',CodigoDeProducto='$codigoDeProductoUp', Imagen1='$img1', Imagen2='$img2', Imagen3='$img3', Imagen4='$img4'";

if ($imgFinalName != '') {
    $updateQuery .= ", Imagen='$imgFinalName'";
}

if (consultasSQL::UpdateSQL("producto", $updateQuery, "CodigoProd='$codeOldProdUp'")) {
    echo '<script>
    swal({
      title: "Producto actualizado",
      text: "El producto se actualizo con éxito",
      type: "success",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Aceptar",
      cancelButtonText: "Cancelar",
      closeOnConfirm: false,
      closeOnCancel: false
      },
      function(isConfirm) {
      if (isConfirm) {
        location.reload();
      } else {
        location.reload();
      }
    });
  </script>';
} else {
    echo '<script>swal("ERROR", "Ocurrió un error inesperado, por favor intente nuevamente", "error");</script>';
}