<?php
include_once '../models/Cliente.php';
$cliente = isset($_GET['id']) ? Cliente::getById($_GET['id']) : null;
if ($cliente !== null) {
  $_SESSION['cliente'] = $cliente;
  $title = "Editar Cliente";
  include_once '../parts/header.php';
?>
  <main class="container py-5">
    <h1>Edição - Cliente: <?= $cliente->getNome(); ?></h1>

    <form action="../models/Cliente" method="POST" onsubmit="validateRules(event)">
      <input type="hidden" name="method" value="update" />
      <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
      <?php include_once './parts/form.php' ?>
      <button type="submit" class="btn btn-primary">Salvar</button>
      <button type="button" class="btn btn-secondary" onclick="window.location.assign('./')">Cancelar</button>
    </form>

  <?php
  include_once '../parts/footer.php';
} else {
  session_start();
  $_SESSION['message'] = 'Cliente não encontrado!';
  $_SESSION['status'] = 'warning';
  header('Location: ../clientes');
}
