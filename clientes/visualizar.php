<?php
include_once '../models/Cliente.php';
$cliente = isset($_GET['id']) ? Cliente::getById($_GET['id']) : null;
if ($cliente !== null) {
  $_SESSION['cliente'] = $cliente;
  $title = "Visualizar cliente";
  include_once '../parts/header.php';
?>
  <main class="container py-5">
    <h1>Cliente: <?= $cliente->getNome(); ?></h1>

    <form action="../models/Cliente" method="POST" disabled>
      <input type="hidden" name="method" value="update" />
      <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
      <fieldset disabled="disabled">
        <?php include_once './parts/form.php' ?>
      </fieldset>
      <button type="button" class="btn btn-primary" onclick="window.location.href = './editar?id=<?= $_GET['id'] ?>'">Editar</button>
      <button type="button" class="btn btn-secondary" onclick="window.location.href = './'">Cancelar</button>
    </form>

  <?php
  include_once '../parts/footer.php';
} else {
  session_start();
  $_SESSION['message'] = 'Cliente não encontrado!';
  $_SESSION['status'] = 'warning';
  header('Location: ../clientes');
}
