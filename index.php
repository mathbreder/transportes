<?php
  $title = "Home";
  include_once 'parts/header.php';

  $menu = [
    [
      'label' => 'Cadastrar clientes',
      'link' => 'clientes'
    ]
  ];
?>
<main class="container py-5">
  <h1>Bem-vindo ao sistema de gerenciamento de transportes</h1>
  <p>Selecione uma função abaixo</p>
  <?php
    foreach ($menu as $item) {
      echo <<<HTML
        <a href="{$item['link']}" class="btn btn-primary">{$item['label']}</a>
      HTML;
    } ?>
</main>
<?php include_once 'parts/footer.php';?>
