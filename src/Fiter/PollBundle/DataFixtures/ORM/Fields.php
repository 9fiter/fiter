<?php

namespace Fiter\PollBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fiter\PollBundle\Entity\Field;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class Fields extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    /**
     * @var ContainerInterface
     */
    private $container;
    public function setContainer(ContainerInterface $container = null){
      $this->container = $container;
    }
    public function getOrder(){ return 31; }
    public function load(ObjectManager $manager)    {
        
        $field=array();
        $field[1] = new Field();
        //$field[1]->setUsuario($this->getReference('usr-moi'));
        $field[1]->setTitle('Pellentesque');
        $field[1]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[1]->setPoll($manager->merge($this->getReference('poll-1')));
        $manager->persist($field[1]);

        $field[2] = new Field();
        //$field[2]->setUsuario($this->getReference('usr-moi'));
        $field[2]->setTitle('Pristique');
        $field[2]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[2]->setPoll($manager->merge($this->getReference('poll-1')));
        $manager->persist($field[2]);







        $field[3] = new Field();
        $field[3]->setTitle('condimentum ');
        $field[3]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[3]->setPoll($manager->merge($this->getReference('poll-2')));
        $manager->persist($field[3]);

        $field[4] = new Field();
        $field[4]->setTitle('lacinia');
        $field[4]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[4]->setPoll($manager->merge($this->getReference('poll-2')));
        $manager->persist($field[4]);






        $field[5] = new Field();
        $field[5]->setTitle('suscipit');
        $field[5]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[5]->setPoll($manager->merge($this->getReference('poll-3')));
        $manager->persist($field[5]);

        $field[6] = new Field();
        $field[6]->setTitle('aptent');
        $field[6]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[6]->setPoll($manager->merge($this->getReference('poll-3')));
        $manager->persist($field[6]);

        $field[7] = new Field();
        $field[7]->setTitle('facilisis');
        $field[7]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[7]->setPoll($manager->merge($this->getReference('poll-3')));
        $manager->persist($field[7]);


        $field[8] = new Field();
        $field[8]->setTitle('suscipit');
        $field[8]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[8]->setPoll($manager->merge($this->getReference('poll-4')));
        $manager->persist($field[8]);

        $field[9] = new Field();
        $field[9]->setTitle('aptent');
        $field[9]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[9]->setPoll($manager->merge($this->getReference('poll-4')));
        $manager->persist($field[9]);




        $field[10] = new Field();
        $field[10]->setTitle('facilisis');
        $field[10]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[10]->setPoll($manager->merge($this->getReference('poll-5')));
        $manager->persist($field[10]);


        $field[11] = new Field();
        $field[11]->setTitle('facilisis');
        $field[11]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[11]->setPoll($manager->merge($this->getReference('poll-5')));
        $manager->persist($field[11]);





        $field[12] = new Field();
        $field[12]->setTitle('facilisis');
        $field[12]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[12]->setPoll($manager->merge($this->getReference('poll-6')));
        $manager->persist($field[12]);

        $field[13] = new Field();
        $field[13]->setTitle('facilisis');
        $field[13]->setCreatedAt(new \DateTime("2011-07-23 06:15:20"));
        $field[13]->setPoll($manager->merge($this->getReference('poll-6')));
        $manager->persist($field[13]);





        

        $manager->flush();
        foreach ($field as $x=> $value) {
            // create the ACL for $field1
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($field[$x]);
            $acl = $aclProvider->createAcl($objectIdentity);
            //if($x=1) $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('usr-moi'));
            //else
                 $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('usr-anon'));
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
        }
    }
}
?>