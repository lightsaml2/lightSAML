<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\State\Request;

use LightSaml\Meta\ParameterBag;

class RequestState
{
    /** @var string */
    private $id;

    /** @var ParameterBag */
    private $parameters;

    /**
     * @param string $id
     * @param mixed  $nonce
     */
    public function __construct($id = null, $nonce = null)
    {
        $this->id = $id;
        $this->parameters = new ParameterBag();
        if ($nonce) {
            $this->parameters->set('nonce', $nonce);
        }
    }

    /**
     * @param string $id
     *
     * @return RequestState
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ParameterBag
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @deprecated Since 1.2, to be removed in 2.0. Use getParameters() instead
     *
     * @param mixed $nonce
     *
     * @return RequestState
     */
    public function setNonce($nonce)
    {
        $this->parameters->set('nonce', $nonce);

        return $this;
    }

    /**
     * @deprecated Since 1.2, to be removed in 2.0. Use getParameters() instead
     *
     * @return mixed
     */
    public function getNonce()
    {
        return $this->parameters->get('nonce');
    }

    public function __serialize(): array {
        return [
            'id' => $this->id,
            'parameters' => $this->parameters->all()
        ];
    }

    public function __unserialize(array $data): void {
        $this->id = $data['id'];
        $this->parameters = new ParameterBag($data['parameters']);
    }
}
