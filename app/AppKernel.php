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
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Fiter\DefaultBundle\FiterDefaultBundle(),
            new Fiter\AdminBundle\FiterAdminBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Ideup\SimplePaginatorBundle\IdeupSimplePaginatorBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Fiter\UserBundle\FiterUserBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new Fiter\CommentBundle\FiterCommentBundle(),
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new Fiter\ContactBundle\FiterContactBundle(),
            new Ivory\LuceneSearchBundle\IvoryLuceneSearchBundle(),
            new BeSimple\I18nRoutingBundle\BeSimpleI18nRoutingBundle(),
            new Bait\PollBundle\BaitPollBundle(),
            new Fiter\PollBundle\FiterPollBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Sonata\jQueryBundle\SonatajQueryBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            //new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Fiter\TeamspeakBundle\FiterTeamspeakBundle(),
            new Fiter\MinecraftBundle\FiterMinecraftBundle(),
            new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new PunkAve\FileUploaderBundle\PunkAveFileUploaderBundle(),
            new Raindrop\GeoipBundle\RaindropGeoipBundle(),
            new Fiter\PhotoContestBundle\FiterPhotoContestBundle(),
            new Nbobtc\Bundle\BitcoindBundle\BitcoindBundle(),
            new Fiter\BitcoinBundle\FiterBitcoinBundle(),
            new Fiter\MinecraftDonationBundle\FiterMinecraftDonationBundle(),
            new JMS\Payment\CoreBundle\JMSPaymentCoreBundle(),
            new JMS\Payment\PaypalBundle\JMSPaymentPaypalBundle(),
            


            new Fiter\Payment\BitcoinBundle\FiterPaymentBitcoinBundle(),
            new Wikp\PaymentMtgoxBundle\WikpPaymentMtgoxBundle(),
            new Fiter\BackupBundle\FiterBackupBundle(),
            new BCC\CronManagerBundle\BCCCronManagerBundle(),
            new Fiter\CronManagerBundle\FiterCronManagerBundle(),
            new Fiter\MinecraftSchematicBundle\FiterMinecraftSchematicBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
