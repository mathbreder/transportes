<?php
include_once '../db_connect.php';
include_once '../models/Cliente.php';
include_once 'DAO.php';

class ClienteDAO extends DAO
{
    protected static $table = 'clientes';
    protected static $fields = [
        'id',
        'nm_cliente',
        'ds_nome_fantasia',
        'ds_razao_social',
        'ds_tipo_pessoa',
        'nr_cpf_cnpj',
        'cd_registro',
        'ie_isento_ins_est',
        'nr_inscricao_est',
        'nr_inscricao_mun',
        'nr_inscricao_suframa',
        'nr_cep',
        'ds_endereco',
        'nr_endereco',
        'ds_complemento',
        'nm_bairro',
        'nm_municipio',
        'nm_estado',
        'nm_pais'
    ];
    protected static $attributes = [
        'id' => 'id',
        'nmCliente' => 'nm_cliente',
        'dsNomeFantasia' => 'ds_nome_fantasia',
        'dsRazaoSocial' => 'ds_razao_social',
        'dsTipoPessoa' => 'ds_tipo_pessoa',
        'nrCpfCnpj' => 'nr_cpf_cnpj',
        'cdRegistro' => 'cd_registro',
        'ieIsentoInsEst' => 'ie_isento_ins_est',
        'nrInscricaoEst' => 'nr_inscricao_est',
        'nrInscricaoMun' => 'nr_inscricao_mun',
        'nrInscricaoSuframa' => 'nr_inscricao_suframa',
        'nrCep' => 'nr_cep',
        'dsEndereco' => 'ds_endereco',
        'nrEndereco' => 'nr_endereco',
        'dsComplemento' => 'ds_complemento',
        'nmBairro' => 'nm_bairro',
        'nmMunicipio' => 'nm_municipio',
        'nmEstado' => 'nm_estado',
        'nmPais' => 'nm_pais',
    ];
    protected static $transformations = [
        'ie_isento_ins_est' => ['toBool', 'toDbBool'],
    ];

    /**
     * Get all clients
     * @return array
     */
    public static function getAll()
    {
        $result = parent::getAll();
        $clients = [];
        foreach ($result as $key => $value) {
            $object = parent::toObject($value);

            $clients[$key] = new Cliente($object);
        }
        return $clients;
    }

    /**
     * Get all clients with pagination
     * @return mixed
     */
    public static function getPage($page = 1, $records_per_page = 5)
    {
        $result = parent::getPage($page, $records_per_page);
        $clients = [];
        foreach ($result as $key => $value) {
            $object = parent::toObject($value);
            $clients[$key] = new Cliente($object);
        }
        return $clients;
    }

    /**
     * Get an client by id
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        $result = parent::getById($id);
        $object = parent::toObject($result);
        $object = parent::applyTransformations($object);
        return new Cliente($object);
    }

    /**
     * Transform a value to boolean
     * @param $value
     * @return bool
     */
    protected static function toBool($value)
    {
        return $value === '1' || $value === 1 || $value === true;
    }

    /**
     * Transform a value to database boolean
     * @param $value
     * @return int
     */
    protected static function toDbBool($value)
    {
        return $value ? 1 : 0;
    }
}
