<?php
include_once '../daos/ClienteDAO.php';
include_once 'Model.php';

class Cliente extends Model
{
    public static $dao = 'ClienteDAO';

    public $id;
    public $nmCliente;
    public $dsNomeFantasia;
    public $dsRazaoSocial;
    public $dsTipoPessoa;
    public $nrCpfCnpj;
    public $cdRegistro;
    public $ieIsentoInsEst;
    public $nrInscricaoEst;
    public $nrInscricaoMun;
    public $nrInscricaoSuframa;
    public $nrCep;
    public $dsEndereco;
    public $nrEndereco;
    public $dsComplemento;
    public $nmBairro;
    public $nmMunicipio;
    public $nmEstado;
    public $nmPais;

    /**
     * Cliente constructor.
     * @param $data array of data to be set
     */
    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->nmCliente = $data['nmCliente'] ?? null;
        $this->dsNomeFantasia = $data['dsNomeFantasia'] ?? null;
        $this->dsRazaoSocial = $data['dsRazaoSocial'] ?? null;
        $this->dsTipoPessoa = $data['dsTipoPessoa'];
        $this->nrCpfCnpj = $data['nrCpfCnpj'];
        $this->cdRegistro = $data['cdRegistro'];
        $this->ieIsentoInsEst = $data['ieIsentoInsEst'] ?? false;
        $this->nrInscricaoEst = $data['nrInscricaoEst'] ?? null;
        $this->nrInscricaoMun = $data['nrInscricaoMun'];
        $this->nrInscricaoSuframa = $data['nrInscricaoSuframa'];
        $this->nrCep = $data['nrCep'];
        $this->dsEndereco = $data['dsEndereco'];
        $this->nrEndereco = $data['nrEndereco'];
        $this->dsComplemento = $data['dsComplemento'];
        $this->nmBairro = $data['nmBairro'];
        $this->nmMunicipio = $data['nmMunicipio'];
        $this->nmEstado = $data['nmEstado'];
        $this->nmPais = $data['nmPais'];
    }

    /**
     * Create an client
     */
    public function create(): void
    {
        parent::create();
        Cliente::redirect('Cliente cadastrado com sucesso!', '/clientes/');
    }

    /**
     * Update an client
     */
    public function update(): void
    {
        parent::update();
        $nome = $this->getNome();
        Cliente::redirect(`Cliente "$nome" atualizado com sucesso!`, '/clientes/');
    }

    /**
     * Delete an client
     */
    public function delete(): void
    {
        parent::delete();
        $nome = $this->nmCliente ?? $this->dsNomeFantasia ?? $this->dsRazaoSocial;
        Cliente::redirect(`Cliente "$nome" excluído com sucesso!`, '/clientes/', 'danger');
    }

    /**
     * Get all clients
     * @return Cliente[]
     */
    public static function getAll(): array
    {
        return ClienteDAO::getAll();
    }

    /**
     * Get all clients with pagination
     * @return Cliente[]
     */
    public static function getPage($page = 1, $records_per_page = 5): array
    {
        return ClienteDAO::getPage($page, $records_per_page);
    }

    /**
     * Get an client by id
     * @param $id
     * @return Cliente
     */
    public static function getById($id): Cliente
    {
        return ClienteDAO::getById($id);
    }

    /**
     * Get number of total records in the database
     * @return int
     */
    public static function getTotal(): int
    {
        return ClienteDAO::getTotal();
    }

    /**
     * Get the name of the client
     * @return string
     */
    public function getNome(): string
    {
        return $this->nmCliente ?? $this->dsNomeFantasia ?? $this->dsRazaoSocial;
    }

    /**
     * Get the type of the client
     * @return string
     */
    public function getTipoPessoa(): string
    {
        $tipos = [
            'PF' => 'Pessoa Física',
            'PJ' => 'Pessoa Jurídica',
            'O' => 'Outros'
        ];
        return $tipos[$this->dsTipoPessoa] ?? 'Não informado';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['method'])) {
    $method = $_POST['method'];
    if (method_exists('Cliente', $method)) {
        $cliente = new Cliente($_POST);
        $cliente->$method();
    } else {
        echo 'Metodo incorreto';
    }
}
