<?php

namespace LightSaml\Tests\Binding;

use LightSaml\Binding\HttpRedirectBinding;
use LightSaml\Context\Profile\MessageContext;
use LightSaml\Tests\BaseTestCase;
use Symfony\Component\HttpFoundation\Request;

class HttpRedirectBindingTest extends BaseTestCase
{
    public function test__receive_throws_when_no_message()
    {
        $this->expectException('LightSaml\Error\LightSamlBindingException');
        $this->expectExceptionMessage('Missing SAMLRequest or SAMLResponse parameter');
        $request = new Request();

        $binding = new HttpRedirectBinding();

        $messageContext = new MessageContext();

        $binding->receive($request, $messageContext);
    }
}
