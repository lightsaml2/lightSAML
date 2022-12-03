<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\State\Sso;

use LightSaml\Meta\ParameterBag;

class SsoState
{
    /** @var string */
    private $localSessionId;

    /** @var ParameterBag */
    private $parameters;

    /** @var SsoSessionState[] */
    private $ssoSessions = [];

    public function __construct()
    {
        $this->parameters = new ParameterBag();
    }

    /**
     * @return string
     */
    public function getLocalSessionId()
    {
        return $this->localSessionId;
    }

    /**
     * @param string $localSessionId
     *
     * @return SsoState
     */
    public function setLocalSessionId($localSessionId)
    {
        $this->localSessionId = $localSessionId;

        return $this;
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
     * @return array
     */
    public function getOptions()
    {
        return $this->parameters->all();
    }

    /**
     * @deprecated Since 1.2, to be removed in 2.0. Use getParameters() instead
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return SsoState
     */
    public function addOption($name, $value)
    {
        $this->parameters->set($name, $value);

        return $this;
    }

    /**
     * @deprecated Since 1.2, to be removed in 2.0. Use getParameters() instead
     *
     * @param string $name
     *
     * @return SsoState
     */
    public function removeOption($name)
    {
        $this->parameters->remove($name);

        return $this;
    }

    /**
     * @deprecated Since 1.2, to be removed in 2.0. Use getParameters() instead
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasOption($name)
    {
        return $this->parameters->has($name);
    }

    /**
     * @return SsoSessionState[]
     */
    public function getSsoSessions()
    {
        return $this->ssoSessions;
    }

    /**
     * @param SsoSessionState[] $ssoSessions
     *
     * @return SsoState
     */
    public function setSsoSessions(array $ssoSessions)
    {
        $this->ssoSessions = [];
        foreach ($ssoSessions as $ssoSession) {
            $this->addSsoSession($ssoSession);
        }

        return $this;
    }

    /**
     * @return SsoState
     */
    public function addSsoSession(SsoSessionState $ssoSessionState)
    {
        $this->ssoSessions[] = $ssoSessionState;

        return $this;
    }

    /**
     * @param $idpEntityId
     * @param $spEntityId
     * @param $nameId
     * @param $nameIdFormat
     * @param $sessionIndex
     *
     * @return SsoSessionState[]
     */
    public function filter($idpEntityId, $spEntityId, $nameId, $nameIdFormat, $sessionIndex)
    {
        $result = [];

        foreach ($this->ssoSessions as $ssoSession) {
            if ((!$idpEntityId || $ssoSession->getIdpEntityId() === $idpEntityId) &&
                (!$spEntityId || $ssoSession->getSpEntityId() === $spEntityId) &&
                (!$nameId || $ssoSession->getNameId() === $nameId) &&
                (!$nameIdFormat || $ssoSession->getNameIdFormat() === $nameIdFormat) &&
                (!$sessionIndex || $ssoSession->getSessionIndex() === $sessionIndex)
            ) {
                $result[] = $ssoSession;
            }
        }

        return $result;
    }

    /**
     * @param callable $callback
     *
     * @return SsoState
     */
    public function modify($callback)
    {
        $this->ssoSessions = array_values(array_filter($this->ssoSessions, $callback));

        return $this;
    }

    public function __serialize(): array {
        return [
            'id' => $this->localSessionId,
            'sessions' => $this->ssoSessions,
            'parameters' => $this->parameters->all(),
        ];
    }

    public function __unserialize(array $data): void {
        $this->localSessionId = $data['id'];
        $this->ssoSessions = $data['sessions'];
        $this->parameters = new ParameterBag($data['parameters']);
    }
}
