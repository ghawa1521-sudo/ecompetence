<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

    public function registerBundles() {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            /////////////////////////////////////
            new Agent\AgentBundle\AgentBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(), //Pour le upload de fichier
            new Users\UsersBundle\UsersBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Demandes\DemandesBundle\DemandesBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(), //Pour générer les pdf
            #new Gos\Bundle\WebSocketBundle\GosWebSocketBundle(),
            #new Gos\Bundle\PubSubRouterBundle\GosPubSubRouterBundle(),
// new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            //new Ensepar\Html2pdfBundle\EnseparHtml2pdfBundle(),
            new DataDog\AuditBundle\DataDogAuditBundle(),
            new DataDog\PagerBundle\DataDogPagerBundle(),
            //new Knp\Bundle\TimeBundle\KnpTimeBundle(),
            //new DH\DoctrineAuditBundle\DHDoctrineAuditBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Core23\DompdfBundle\Core23DompdfBundle(),
            new Annuaire\AnnuaireBundle\AnnuaireBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new AppVentus\AlertifyBundle\AvAlertifyBundle(),
            new BiblioBundle\BiblioBundle(),
            new Ediligence\EdiligenceBundle\EdiligenceBundle(),
            new Knp\Bundle\TimeBundle\KnpTimeBundle(),
            new PasBundle\PasBundle(),
            new Agent\IdentificationBundle\AgentIdentificationBundle(),
            new Ecompetence\EcompetenceBundle\EcompetenceBundle(),
            new gbaneBundle\gbaneBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            //$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    public function __construct($environment, $debug) {
        date_default_timezone_set('Africa/Abidjan');
        parent::__construct($environment, $debug);
    }

}
