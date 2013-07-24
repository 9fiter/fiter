<?php

namespace Fiter\PollBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fiter\PollBundle\Entity\Poll;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class Polls extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    /**
     * @var ContainerInterface
     */
    private $container;
    public function setContainer(ContainerInterface $container = null){
      $this->container = $container;
    }
    public function getOrder(){ return 30; }
    public function load(ObjectManager $manager)    {
        
        $poll=array();
        $poll[1] = new Poll();
        $poll[1]->setUsuario($this->getReference('usr-moi'));
        $poll[1]->setTitle('Pellentesque habitant morbi tristique senectus et netus');
        $poll[1]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $manager->persist($poll[1]);


      
        $poll[2] = new Poll();
        $poll[2]->setUsuario($this->getReference('usr-moi'));
        $poll[2]->setTitle('Suspendisse in justo eu magna?');
        $poll[2]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $manager->persist($poll[2]);

        $poll[3] = new Poll();
        $poll[3]->setUsuario($this->getReference('usr-moi'));
        $poll[3]->setTitle('Integer lacinia sollicitudin massa');
        $poll[3]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $manager->persist($poll[3]);

        $poll[4] = new Poll();
        $poll[4]->setUsuario($this->getReference('usr-moi'));
        $poll[4]->setTitle('Ultrices posuere cubilia');
        $poll[4]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $manager->persist($poll[4]);

        $poll[5] = new Poll();
        $poll[5]->setUsuario($this->getReference('usr-moi'));
        $poll[5]->setTitle('Quisque nisl felis, venenatis tristique dignissim in?');
        $poll[5]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $manager->persist($poll[5]);

        $poll[6] = new Poll();
        $poll[6]->setUsuario($this->getReference('usr-moi'));
        $poll[6]->setTitle('Mauris ipsum. Nulla met uet?');
        $poll[6]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $manager->persist($poll[6]);





        $manager->flush();
        foreach ($poll as $x=> $value) {
            // create the ACL for $poll1
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($poll[$x]);
            $acl = $aclProvider->createAcl($objectIdentity);
            //if($x=1) $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('usr-moi'));
            //else
                 $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('usr-anon'));
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
        }

        $this->AddReference('poll-1', $poll[1]);
        $this->AddReference('poll-2', $poll[2]);
        $this->AddReference('poll-3', $poll[3]);
        $this->AddReference('poll-4', $poll[4]);
        $this->AddReference('poll-5', $poll[5]);
        $this->AddReference('poll-6', $poll[6]);
        
        


    }
}
?>