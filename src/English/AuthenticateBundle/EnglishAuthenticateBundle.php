<?php

namespace English\AuthenticateBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EnglishAuthenticateBundle extends Bundle
{
    public function getParent() 
    {
        return 'FOSUserBundle';
    }
}
