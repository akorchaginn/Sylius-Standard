<?php


namespace IntegrationBundle\Entity;


interface IntegrationInterface
{
    /**
     * @return string
     */
    public function getId1c(): ?string;

    /**
     * @param string $id1c
     */
    public function setId1c(?string $id1c): void;
}