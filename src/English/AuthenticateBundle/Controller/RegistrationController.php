<?php

/*
 * This file overrides the RegistrationController of the FOSUserBundel
 *
 */

namespace English\AuthenticateBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use English\PeopleBundle\Entity\People;
use English\GradinfoBundle\Entity\Gradinfo;

class RegistrationController extends BaseController
{

}
