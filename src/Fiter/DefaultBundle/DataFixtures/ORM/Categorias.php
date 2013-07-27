<?php

namespace Fiter\DebateBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fiter\DefaultBundle\Entity\Categoria;



use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class Categorias extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    public function setContainer(ContainerInterface $container = null){
      $this->container = $container;
    }
    public function getOrder(){ return 1; }
    public function load(ObjectManager $manager){
        
        $cat=array();
        
        $cat[1] = new Categoria();
        $cat[1]->setUsuario($this->getReference('usr-anon'));
        $cat[1]->setNombre('Programación');
        //$cat[1]->setImagen('internacional.png');
        //$cat[1]->setPath('eb1ab2075fe80db9f935eb0e588c5331f70e4ac4.png');
        $cat[1]->setVisitas(80);
        $manager->persist($cat[1]);
        $manager->flush();


            $cat[1]->setNombre('Programación');
            $cat[1]->setTranslatableLocale('gl');
            $manager->persist($cat[1]);
            $manager->flush();

            $cat[1]->setNombre('Programación');
            $cat[1]->setTranslatableLocale('ca');
            $manager->persist($cat[1]);
            $manager->flush();

            $cat[1]->setNombre('Programming');
            $cat[1]->setTranslatableLocale('en');
            $manager->persist($cat[1]);
            $manager->flush();
        
        
        $cat[2] = new Categoria();
        $cat[2]->setUsuario($this->getReference('usr-anon'));
        $cat[2]->setNombre('Diseño web');
        //$cat[2]->setPath('d5ffc42f02c2ee4493ee1515987a601d9ed9490e.jpeg');
        $cat[2]->setVisitas(78);
        $manager->persist($cat[2]);
        $manager->flush();

            $cat[2]->setNombre('Diseño web');
            $cat[2]->setTranslatableLocale('gl');
            $manager->persist($cat[2]);
            $manager->flush();

            $cat[2]->setNombre('Diseño web');
            $cat[2]->setTranslatableLocale('ca');
            $manager->persist($cat[2]);
            $manager->flush();

            $cat[2]->setNombre('Diseño web');
            $cat[2]->setTranslatableLocale('en');
            $manager->persist($cat[2]);
            $manager->flush();
        
        $cat[3] = new Categoria();
        $cat[3]->setUsuario($this->getReference('usr-anon'));
        $cat[3]->setNombre('Política');
        //$cat[3]->setPath('c6cf7493905da31b3d154e19b52311c6b5805453.jpeg');
        $cat[3]->setVisitas(66);
        $manager->persist($cat[3]);
        $manager->flush();

            $cat[3]->setNombre('Política');
            $cat[3]->setTranslatableLocale('gl');
            $manager->persist($cat[3]);
            $manager->flush();

            $cat[3]->setNombre('Política');
            $cat[3]->setTranslatableLocale('ca');
            $manager->persist($cat[3]);
            $manager->flush();

            $cat[3]->setNombre('Politics');
            $cat[3]->setTranslatableLocale('en');
            $manager->persist($cat[3]);
            $manager->flush();
        
        $cat[4] = new Categoria();
        $cat[4]->setUsuario($this->getReference('usr-anon'));
        $cat[4]->setNombre('Economía');
        //$cat[4]->setPath('afaa9458354b074c68c6a480a5525a2a25c03ea7.jpeg');
        $cat[4]->setVisitas(60);
        $manager->persist($cat[4]);
        $manager->flush();

            $cat[4]->setNombre('Economía');
            $cat[4]->setTranslatableLocale('gl');
            $manager->persist($cat[4]);
            $manager->flush();

            $cat[4]->setNombre('Economia');
            $cat[4]->setTranslatableLocale('ca');
            $manager->persist($cat[4]);
            $manager->flush();

            $cat[4]->setNombre('Economy');
            $cat[4]->setTranslatableLocale('en');
            $manager->persist($cat[4]);
            $manager->flush();
        
        $cat[5] = new Categoria();
        $cat[5]->setUsuario($this->getReference('usr-anon'));
        $cat[5]->setNombre('Ciencia');
        //$cat[5]->setPath('0a489ebc3e7e6f8e80da9823c62ed6ae668b9628.jpeg');
        $cat[5]->setVisitas(57);
        $manager->persist($cat[5]);
        $manager->flush();

            $cat[5]->setNombre('Ciencia');
            $cat[5]->setTranslatableLocale('gl');
            $manager->persist($cat[5]);
            $manager->flush();

            $cat[5]->setNombre('Ciència');
            $cat[5]->setTranslatableLocale('ca');
            $manager->persist($cat[5]);
            $manager->flush();

            $cat[5]->setNombre('Science');
            $cat[5]->setTranslatableLocale('en');
            $manager->persist($cat[5]);
            $manager->flush();
        
        $cat[6] = new Categoria();
        $cat[6]->setUsuario($this->getReference('usr-anon'));
        $cat[6]->setNombre('Agricultura');
        //$cat[6]->setPath('a6383a90e246d4bf973b142fa1c286515c9d568d.jpeg');
        $cat[6]->setVisitas(47);
        $manager->persist($cat[6]);
        $manager->flush();

            $cat[6]->setNombre('Agricultura');
            $cat[6]->setTranslatableLocale('gl');
            $manager->persist($cat[6]);
            $manager->flush();

            $cat[6]->setNombre('Agricultura');
            $cat[6]->setTranslatableLocale('ca');
            $manager->persist($cat[6]);
            $manager->flush();

            $cat[6]->setNombre('Agriculture');
            $cat[6]->setTranslatableLocale('en');
            $manager->persist($cat[6]);
            $manager->flush();
        
        $cat[7] = new Categoria();
        $cat[7]->setUsuario($this->getReference('usr-anon'));
        $cat[7]->setNombre('Derechos humanos');
        //$cat[7]->setPath('8b87c8b147bde894e67a9853be2eb8bed9024717.jpeg');
        $cat[7]->setVisitas(58);
        $manager->persist($cat[7]);
        $manager->flush();

            $cat[7]->setNombre('Dereitos humanos');
            $cat[7]->setTranslatableLocale('gl');
            $manager->persist($cat[7]);
            $manager->flush();

            $cat[7]->setNombre('Drets humans');
            $cat[7]->setTranslatableLocale('ca');
            $manager->persist($cat[7]);
            $manager->flush();

            $cat[7]->setNombre('Human rights');
            $cat[7]->setTranslatableLocale('en');
            $manager->persist($cat[7]);
            $manager->flush();
        
        $cat[8] = new Categoria();
        $cat[8]->setUsuario($this->getReference('usr-anon'));
        $cat[8]->setNombre('Cultura');
        //$cat[8]->setPath('1ca6a3c1423e9240c63dbb9d0e4d9532263ecf26.jpeg');
        $cat[8]->setVisitas(55);
        $manager->persist($cat[8]);
        $manager->flush();

            $cat[8]->setNombre('Cultura');
            $cat[8]->setTranslatableLocale('gl');
            $manager->persist($cat[8]);
            $manager->flush();

            $cat[8]->setNombre('Cultura');
            $cat[8]->setTranslatableLocale('ca');
            $manager->persist($cat[8]);
            $manager->flush();

            $cat[8]->setNombre('Culture');
            $cat[8]->setTranslatableLocale('en');
            $manager->persist($cat[8]);
            $manager->flush();



        
        $cat[9] = new Categoria();
        $cat[9]->setUsuario($this->getReference('usr-anon'));
        $cat[9]->setNombre('Sociedad');
        //$cat[9]->setPath('a06ff588624c7c649b7b9c6ff705caa32e38ea02.jpeg');
        $cat[9]->setVisitas(64);
        $manager->persist($cat[9]);
        $manager->flush();

            $cat[9]->setNombre('Sociedade');
            $cat[9]->setTranslatableLocale('gl');
            $manager->persist($cat[9]);
            $manager->flush();

            $cat[9]->setNombre('Societat');
            $cat[9]->setTranslatableLocale('ca');
            $manager->persist($cat[9]);
            $manager->flush();

            $cat[9]->setNombre('Society');
            $cat[9]->setTranslatableLocale('en');
            $manager->persist($cat[9]);
            $manager->flush();

        /*
        $cat[10] = new Categoria();
        $cat[10]->setUsuario($this->getReference('usr-anon'));
        $cat[10]->setNombre('Blogs');
        //$cat[10]->setImagen('blogs.png');
        $cat[10]->setVisitas(72);
        $manager->persist($cat[10]);
        */
        
        $cat[11] = new Categoria();
        $cat[11]->setUsuario($this->getReference('usr-anon'));
        $cat[11]->setNombre('Educación');
        //$cat[11]->setPath('d133cc3a59af3bd7fd8446e64885ca971de51dfc.jpeg');
        $cat[11]->setVisitas(68);
        $manager->persist($cat[11]);
        $manager->flush();

            $cat[11]->setNombre('Educación');
            $cat[11]->setTranslatableLocale('gl');
            $manager->persist($cat[11]);
            $manager->flush();

            $cat[11]->setNombre('Educació');
            $cat[11]->setTranslatableLocale('ca');
            $manager->persist($cat[11]);
            $manager->flush();

            $cat[11]->setNombre('Education');
            $cat[11]->setTranslatableLocale('en');
            $manager->persist($cat[11]);
            $manager->flush();
        
        $cat[12] = new Categoria();
        $cat[12]->setUsuario($this->getReference('usr-anon'));
        $cat[12]->setNombre('Historia');
        //$cat[12]->setPath('6ee3114d3ad9bba1f5042772dbcf9dda699329b3.jpeg');
        $cat[12]->setVisitas(60);
        $manager->persist($cat[12]);
        $manager->flush();

            $cat[12]->setNombre('Historia');
            $cat[12]->setTranslatableLocale('gl');
            $manager->persist($cat[12]);
            $manager->flush();

            $cat[12]->setNombre('Història');
            $cat[12]->setTranslatableLocale('ca');
            $manager->persist($cat[12]);
            $manager->flush();

            $cat[12]->setNombre('History');
            $cat[12]->setTranslatableLocale('en');
            $manager->persist($cat[12]);
            $manager->flush();

        
        $cat[13] = new Categoria();
        $cat[13]->setUsuario($this->getReference('usr-anon'));
        $cat[13]->setNombre('Religión');
        //$cat[13]->setPath('dc71aae70a8bfc322399a0e1a4b29cee54848377.jpeg');
        $cat[13]->setVisitas(50);
        $manager->persist($cat[13]);
        $manager->flush();

            $cat[13]->setNombre('Relixión');
            $cat[13]->setTranslatableLocale('gl');
            $manager->persist($cat[13]);
            $manager->flush();

            $cat[13]->setNombre('Religió');
            $cat[13]->setTranslatableLocale('ca');
            $manager->persist($cat[13]);
            $manager->flush();

            $cat[13]->setNombre('Religion');
            $cat[13]->setTranslatableLocale('en');
            $manager->persist($cat[13]);
            $manager->flush();
        
        /*
        $cat[14] = new Categoria();
        $cat[14]->setUsuario($this->getReference('usr-anon'));
        $cat[14]->setNombre('Fraudes');
        //$cat[14]->setImagen('fraudes.png');
        $cat[14]->setVisitas(33);
        $manager->persist($cat[14]);
        
        $cat[15] = new Categoria();
        $cat[15]->setUsuario($this->getReference('usr-anon'));
        $cat[15]->setNombre('Exclavitud');
        //$cat[15]->setImagen('exclavitud.png');
        $cat[15]->setVisitas(25);
        $manager->persist($cat[15]);
        */
        $cat[16] = new Categoria();
        $cat[16]->setUsuario($this->getReference('usr-anon'));
        $cat[16]->setNombre('Desinformación');
        //$cat[16]->setPath('18a5ba2c0a3da730d33ed6d1cef6096865108f16.jpeg');
        $cat[16]->setVisitas(54);
        $manager->persist($cat[16]);
        $manager->flush();

            $cat[16]->setNombre('Desinformación');
            $cat[16]->setTranslatableLocale('gl');
            $manager->persist($cat[16]);
            $manager->flush();

            $cat[16]->setNombre('Desinformació');
            $cat[16]->setTranslatableLocale('ca');
            $manager->persist($cat[16]);
            $manager->flush();

            $cat[16]->setNombre('Disinformation');
            $cat[16]->setTranslatableLocale('en');
            $manager->persist($cat[16]);
            $manager->flush();
        
        $cat[17] = new Categoria();
        $cat[17]->setUsuario($this->getReference('usr-anon'));
        $cat[17]->setNombre('Guerra');
        //$cat[17]->setPath('763f6bfd4e073889914321aab5cc235051b691b5.jpeg');
        $cat[17]->setVisitas(67);
        $manager->persist($cat[17]);
        $manager->flush();

            $cat[17]->setNombre('Guerra');
            $cat[17]->setTranslatableLocale('gl');
            $manager->persist($cat[17]);
            $manager->flush();

            $cat[17]->setNombre('Guerra');
            $cat[17]->setTranslatableLocale('ca');
            $manager->persist($cat[17]);
            $manager->flush();

            $cat[17]->setNombre('War');
            $cat[17]->setTranslatableLocale('en');
            $manager->persist($cat[17]);
            $manager->flush();
        
        $manager->flush();
        
        
        
        foreach ($cat as $x=> $value) {
            // create the ACL for $articulo1
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($cat[$x]);
            $acl = $aclProvider->createAcl($objectIdentity);
            $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('usr-anon'));
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
        }
        
        
        
        $this->AddReference('cat-programacion', $cat[1]);
        $this->addReference('cat-diseñoweb', $cat[2]);
        $this->addReference('cat-politica', $cat[3]);
        $this->addReference('cat-economia', $cat[4]);
        $this->addReference('cat-ciencia', $cat[5]);
        $this->addReference('cat-agricultura', $cat[6]);
        $this->addReference('cat-derechos-humanos', $cat[7]);
        $this->addReference('cat-cultura', $cat[8]);
        $this->addReference('cat-sociedad', $cat[9]);
        //$this->addReference('cat-blogs', $cat10);
        $this->addReference('cat-educacion', $cat[11]);
        $this->addReference('cat-historia', $cat[12]);
        $this->addReference('cat-religion', $cat[13]);
        //$this->addReference('cat-fraudes', $cat14);
        //$this->addReference('cat-exclavitud', $cat15);
        $this->addReference('cat-desinformacion', $cat[16]);
        $this->addReference('cat-guerra', $cat[17]);
    }
}
?>
