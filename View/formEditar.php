<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../public/css/home.css">
    
  </head>
<body>
    
<div class="container mt-3">
  <div class="row justify-content-md-center">
    <div class="col-md-12">
      <h1 class="text-center mt-3">
        <a href="./">
          <i class="bi bi-arrow-left-circle"></i>
        </a>
        Actualizar Datos del Pasajero
      </h1>
      <hr class="mb-3">
    </div>


    
    <?php
    include('config.php');
    

    

    $idPasajero     = (int) filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
    $sqlPasajeros   = ("SELECT * FROM table_pasajeros WHERE id='$idPasajero' LIMIT 1");
    $queryPasajeros = mysqli_query($con, $sqlPasajeros);
    $dataPasajero   = mysqli_fetch_array($queryPasajeros);
    ?>

    <div class="col-md-5 mb-3">
      <h3 class="text-center">Datos del Pasajero</h3>
      <form method="POST" action="actionCompleto.php?metodo=2" enctype="multipart/form-data">
      <input type="text" name="id" value="<?php echo $dataPasajero['id']; ?>" hidden>
      <div class="mb-3">
          <label class="form-label">Nombre y Apellido</label>
          <input type="text" class="form-control" name="namefull" value="<?php echo $dataPasajero['namefull']; ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Cedula (nit)</label>
          <input type="number" name="cedula" class="form-control" value="<?php echo $dataPasajero['cedula']; ?>">
        </div>

        <div class="mb-3">
        <label for="Sexo">Sexo del Pasajero</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="sexo" value="M" <?php echo $dataPasajero['sexo']==='M' ?  'checked' : '' ?> checked>
            <label class="form-check-label" for="sexoM">
              Masculino
            </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="sexo" value="F" <?php echo $dataPasajero['sexo']==='F' ?  'checked' : '' ?>>
          <label class="form-check-label" for="sexoF">
            Fememino
          </label>
        </div>
        </div>
        <div class="mb-3">
          <label for="Sexo">Secci&oacute;n</label>
          <select class="form-select" name="section">
          <?php  
            if($dataPasajero['section'] =="A"){
              echo '<option value="A" selected>A</option>';
              echo '<option value="B">B</option>';
              echo '<option value="C">C</option>';
            }elseif($dataPasajero['section'] =="B"){
              echo '<option value="B" selected>B</option>';
              echo '<option value="A">A</option>';
              echo '<option value="C">C</option>';
            }else{
              echo '<option value="C" selected>C</option>';
              echo '<option value="A">A</option>';
              echo '<option value="B">B</option>';
            }
          ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Foto del Pasajero</label>
          <input class="form-control" type="file" name="foto" accept="image/png,image/jpeg">
        </div>

        <div class="d-grid gap-2 col-12 mx-auto">
          <button type="submit" class="btn  btn btn-primary mt-3 mb-2">
            Actualizar datos del Pasajero
            <i class="bi bi-arrow-right-circle"></i>
          </button>
        </div>
        
      </form>
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Foto actual del pasajero</label>
        <br>
        <img src="../public/fotosPasajeros/<?php echo $dataPasajero['foto']; ?>" alt="foto perfil" class="card-img-top fotoPerfil">
    </div>



  </div>
</div>

<?php
  include('mensajes.php'); 
?>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
$(function(){
  $('.toast').toast('show');
});
</script>

</body>
</html>