<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\client\web\model;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;

/**
 * Class ClientModelMapperImpl implementation for ClientModelMapper.
 * @package pl\zupka\chinska\mvc\client\web\model
 */
class ClientModelMapperImpl implements ClientModelMapper
{

    public function toModel(ClientDto $clientDto): ClientModel
    {
        // TODO: Implement toModel() method.
        // ... like in \pl\zupka\chinska\mvc\api\entity\mapper\ClientEntityMapperImpl ...
    }

    public function toDto(ClientModel $clientModel): ClientDto
    {
        // TODO: Implement toDto() method.
        // ... like in \pl\zupka\chinska\mvc\api\entity\mapper\ClientEntityMapperImpl ...
    }
}