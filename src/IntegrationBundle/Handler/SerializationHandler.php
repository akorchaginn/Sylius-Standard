<?php

namespace IntegrationBundle\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\XmlSerializationVisitor;

/**
 * Class SerializationHandler
 * @package IntegrationBundle\Handler
 */
class SerializationHandler extends XmlSerializationVisitor
{

    /**
     * {@inheritdoc}
     */
    public function visitNull($data, array $type, Context $context)
    {
        return $this->document->createTextNode((string)$data);
    }
}