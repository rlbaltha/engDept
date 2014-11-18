<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            new FR3D\LdapBundle\FR3DLdapBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new English\AdvisorsBundle\EnglishAdvisorsBundle(),
            new English\AreasBundle\EnglishAreasBundle(),
            new English\CalendarBundle\EnglishCalendarBundle(),
            new English\CoursesBundle\EnglishCoursesBundle(),
            new English\DescriptionsBundle\EnglishDescriptionsBundle(),
            new English\FilesBundle\EnglishFilesBundle(),
            new English\GradcomBundle\EnglishGradcomBundle(),
            new English\GradinfoBundle\EnglishGradinfoBundle(),
            new English\GradnotesBundle\EnglishGradnotesBundle(),
            new English\LinksBundle\EnglishLinksBundle(),
            new English\MajorsBundle\EnglishMajorsBundle(),
            new English\MajornotesBundle\EnglishMajornotesBundle(),
            new English\MentorsBundle\EnglishMentorsBundle(),
            new English\PeopleBundle\EnglishPeopleBundle(),
            new English\SlideshowBundle\EnglishSlideshowBundle(),
            new English\SpotlightBundle\EnglishSpotlightBundle(),
            new English\TermBundle\EnglishTermBundle(),
            new English\HomeBundle\EnglishHomeBundle(),
            new English\PositionBundle\EnglishPositionBundle(),
            new English\AuthenticateBundle\EnglishAuthenticateBundle(),
            new English\DonateBundle\EnglishDonateBundle(),
            new English\DawgspeakBundle\EnglishDawgspeakBundle(),
            new English\PagesBundle\EnglishPagesBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
