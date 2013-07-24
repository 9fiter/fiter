<?php

namespace Fiter\DefaultBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fiter\DefaultBundle\Entity\Usuario;

class Usuarios extends AbstractFixture implements OrderedFixtureInterface{
    public function getOrder(){ return 0; }
    public function load(ObjectManager $manager)    {
        $user = new Usuario();
        $user->setUsername('moi');
        $user->setEmail('user@example.com');
        $user->setPlainPassword('rtrtrt');
        $user->setenabled(true);
        $user -> setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);
        
        $user2 = new Usuario();
        $user2->setUsername('Anónimo');
        $user2->setEmail('anon@example.com');
        $user2->setPlainPassword('rtrtrt');
        $user2->setenabled(true);
        $manager->persist($user2);
        
        $manager->flush();
        
        $this->AddReference('usr-moi', $user);
        $this->AddReference('usr-anon', $user2);
    }
}
?>