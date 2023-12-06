<?php
$title = "Cadastro de clientes";
$page = 'clientes.cadastrar';
include_once '../parts/header.php';
?>
<main class="container py-5">
  <h1>Cadastro de clientes</h1>

  <form action="../models/Cliente" method="POST" onsubmit="validateRules(event)">
    <input type="hidden" name="method" value="create" />
    <?php include_once './parts/form.php' ?>
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
</main>
<?php
include_once '../parts/footer.php';
?>
