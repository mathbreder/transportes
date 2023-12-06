<?php
include_once '../models/Cliente.php';
$title = "Cadastro de clientes";
$page = 'clientes.index';
include_once '../parts/header.php';
?>

<style>
  .table-container {
    overflow-x: auto;
  }

  .min-h-350px {
    min-height: 350px;
  }
</style>

<main class="container py-5">
  <div class="d-flex justify-content-between align-items-end">
    <h1>Clientes</h1>
    <a href="cadastrar" class="btn btn-primary">Cadastrar novo cliente</a>
  </div>

  <?php
  $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
  $recordsPerPage = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int) $_GET['limit'] : 5;
  $numberOfPages = ceil(Cliente::getTotal() / ($recordsPerPage > 0 ? $recordsPerPage : 1));
  $clientes         = Cliente::getPage($page, $recordsPerPage);
  ?>

  <div class="table-container min-h-350px">
    <table class="table table-striped table-hover my-4">
      <caption>Clientes cadastrados no sistema</caption>
      <?php session_start();
      if (isset($_SESSION['message'])) { ?>
        <div class="alert <?= isset($_SESSION['status']) ? 'alert-' . $_SESSION['status'] : 'alert-info'; ?> my-4" role="alert">
          <?php
          echo $_SESSION['message'];
          unset($_SESSION['message']);
          ?>
        </div>
      <?php } ?>
      <thead>
        <tr>
          <th scope="col" class="col-1">#</th>
          <th scope="col" class="col-4">Nome</th>
          <th scope="col" class="col-5">CPF/CNPJ</th>
          <th scope="col" class="col-2"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clientes as $cliente) { ?>
          <tr class="align-middle">
            <th scope="row"><?= $cliente->id; ?></th>
            <td><?= $cliente->nmCliente ?? $cliente->dsNomeFantasia; ?></td>
            <td><?= $cliente->nrCpfCnpj ?? ''; ?></td>
            <td class="d-flex justify-content-end">
              <a href="visualizar?id=<?= $cliente->id; ?>" class="btn btn-success mx-1">Visualizar</a>
              <a href="editar?id=<?= $cliente->id; ?>" class="btn btn-primary mx-1">Editar</a>
              <button class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="askDelete(event)">Excluir</button>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-start">
  <a href="../" class="btn btn-secondary">Voltar</a>
  <nav aria-label="Clientes por página" class="d-flex justify-content-end">
    <ul class="pagination">
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $page - 1; ?>&limit=<?= $recordsPerPage; ?>">Anterior</a>
      </li>
      <?php
      $firstPage = 1;
      $lastPage = $numberOfPages;
      if ($numberOfPages > 5) {
        $firstPage = $page - 2 > 0 ? $page - 2 : 1;
        $lastPage = $page + 2 <= $numberOfPages ? $page + 2 : $numberOfPages;
      }
      if ($firstPage > 1) { ?>
        <li class="page-item">
          <a class="page-link" href="?page=1&limit=<?= $recordsPerPage; ?>">1</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link">...</a>
        </li>
      <?php }
      for ($i = $firstPage; $i <= $lastPage; $i++) { ?>
        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i; ?>&limit=<?= $recordsPerPage; ?>"><?= $i; ?></a>
        </li>
      <?php }
      if ($lastPage < $numberOfPages) { ?>
        <li class="page-item disabled">
          <a class="page-link">...</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page=<?= $numberOfPages; ?>&limit=<?= $recordsPerPage; ?>"><?= $numberOfPages; ?></a>
        </li>
      <?php } ?>
      <li class="page-item <?= $page >= $numberOfPages ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $page + 1; ?>&limit=<?= $recordsPerPage; ?>">Próximo</a>
      </li>
    </ul>
  </nav>
  </div>
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Deseja excluir o registro?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="client-modal">
          ...
        </div>
        <div class="modal-footer" id="client-modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
          <button type="button" class="btn btn-primary">Sim</button>
        </div>
      </div>
    </div>
  </div>
</main>
  <script>
    const askDelete = (event) => {
      event.preventDefault();
      const register = Array.from(event.target.parentElement.parentElement.cells).map(el => el.textContent);
      const modal = document.querySelector('#client-modal');
      modal.innerHTML = `
      <p>Nome: ${register[1]}</p>
      <p>CPF/CNPJ: ${register[2]}</p>
      `;
      const modalFooter = document.querySelector('#client-modal-footer');
      modalFooter.innerHTML = `
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      <form action="../models/Cliente.php" method="POST">
        <input type="hidden" name="method" value="delete" />
        <input type="hidden" name="id" value="${register[0]}" />
        <input type="hidden" name="nome" value="${register[1]}" />
        <button type="submit" class="btn btn-danger">Excluir</button>
      </form>
      `;
    }
  </script>
  <?php
  include_once '../parts/footer.php';
  ?>