<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\api\entity\mapper;

use pl\zupka\chinska\mvc\api\entity\dto\ClientDto;
use pl\zupka\chinska\mvc\api\entity\vo\ClientVo;

/**
 * Class ClientEntityMapperImpl implementation for ClientEntityMapper.
 *
 * @package pl\zupka\chinska\mvc\api\entity\mapper
 */
class ClientEntityMapperImpl implements ClientEntityMapper
{

    public function toDto(ClientVo $clientVo): ClientDto
    {
        $clientDto = new ClientDto();

        $clientDto->setName($clientVo->getName());
        // TODO: implement other mappings ...

        return $clientDto;
    }

    public function toVo(ClientDto $clientDto): ClientVo
    {
        $clientVo = new ClientVo(
            $clientDto->getName(),
            $clientDto->getSurname(),
            $clientDto->getEmail(),
            $clientDto->getStatus(),
            $clientDto->getTelephone()
        );

        return $clientVo;
    }
}