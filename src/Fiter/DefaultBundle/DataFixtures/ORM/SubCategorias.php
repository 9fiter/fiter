<?php

namespace Fiter\DebateBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fiter\DefaultBundle\Entity\SubCategoria;

class SubCategorias extends AbstractFixture implements OrderedFixtureInterface{
    public function getOrder(){ return 2; }
    public function load(ObjectManager $manager){
        /******************* 
         * Internacional 
         *******************/
        $subcat1 = new SubCategoria();
        $subcat1->setNombre('PHP');
        //$subcat1->setImagen('Europa.png');
        $subcat1->setCategoria($manager->merge($this->getReference('cat-programacion')));
        $subcat1->setUsuario($this->getReference('usr-anon'));
        $manager->persist($subcat1);
        
        $subcat2 = new SubCategoria();
        $subcat2->setNombre('Symfony2');
        //$subcat2->setImagen('eeuu.png');
        $subcat2->setCategoria($manager->merge($this->getReference('cat-programacion')));
        $subcat2->setUsuario($this->getReference('usr-anon'));
        $manager->persist($subcat2);
        
        $subcat3 = new SubCategoria();
        $subcat3->setNombre('Javascript');
        // //$subcat3->setImagen('america-latina.png');
        $subcat3->setCategoria($manager->merge($this->getReference('cat-programacion')));
        $subcat3->setUsuario($this->getReference('usr-anon'));
        $manager->persist($subcat3);
       
        $subcat4 = new SubCategoria();
        $subcat4->setNombre('jQuery');
        //$subcat4->setImagen('oriente.png');
        $subcat4->setCategoria($manager->merge($this->getReference('cat-programacion')));
        $subcat4->setUsuario($this->getReference('usr-anon'));
        $manager->persist($subcat4);
        
        $subcat5 = new SubCategoria();
        $subcat5->setNombre('CSS3');
        //$subcat5->setImagen('asia.png');
        $subcat5->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $subcat5->setUsuario($this->getReference('usr-anon'));
        $manager->persist($subcat5);
        
        $subcat6 = new SubCategoria();
        $subcat6->setNombre('HTML5');
        //$subcat6->setImagen('africa.png');
        $subcat6->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $subcat6->setUsuario($this->getReference('usr-anon'));
        $manager->persist($subcat6);
        
        /******************* 
         * Nacional
         *******************/
        // $subcat7 = new SubCategoria();
        // $subcat7->setNombre('Cataluña');
        // $subcat7->setImagen('cataluña.png');
        // $subcat7->setCategoria($manager->merge($this->getReference('cat-nacional')));
        // $manager->persist($subcat7);
        
        // $subcat8 = new SubCategoria();
        // $subcat8->setNombre('Galicia');
        // $subcat8->setImagen('galicia.png');
        // $subcat8->setCategoria($manager->merge($this->getReference('cat-nacional')));
        // $manager->persist($subcat8);
        
        // $subcat9 = new SubCategoria();
        // $subcat9->setNombre('Madrid');
        // $subcat9->setImagen('madrid.png');
        // $subcat9->setCategoria($manager->merge($this->getReference('cat-nacional')));
        // $manager->persist($subcat9);
        
        // $subcat10 = new SubCategoria();
        // $subcat10->setNombre('País vasco');
        // $subcat10->setImagen('pais-vasco.png');
        // $subcat10->setCategoria($manager->merge($this->getReference('cat-nacional')));
        // $manager->persist($subcat10);
        
        // $subcat11 = new SubCategoria();
        // $subcat11->setNombre('Valencia');
        // $subcat11->setImagen('valencia.png');
        // $subcat11->setCategoria($manager->merge($this->getReference('cat-nacional')));
        // $manager->persist($subcat11);
        
        // $subcat12 = new SubCategoria();
        // $subcat12->setNombre('Otras comunidades');
        // $subcat12->setImagen('otras-comunidades.png');
        // $subcat12->setCategoria($manager->merge($this->getReference('cat-nacional')));
        // $manager->persist($subcat12);
        
        /******************* 
         * Politica
         *******************/
        // $subcat13 = new SubCategoria();
        // $subcat13->setNombre('Congreso');
        // $subcat13->setImagen('congreso.png');
        // $subcat13->setCategoria($manager->merge($this->getReference('cat-politica')));
        // $manager->persist($subcat13);
        
        // $subcat14 = new SubCategoria();
        // $subcat14->setNombre('Moncloa');
        // $subcat14->setImagen('moncloa.png');
        // $subcat14->setCategoria($manager->merge($this->getReference('cat-politica')));
        // $manager->persist($subcat14);
        
        // $subcat15 = new SubCategoria();
        // $subcat15->setNombre('Democracia');
        // $subcat15->setImagen('democracia.png');
        // $subcat15->setCategoria($manager->merge($this->getReference('cat-politica')));
        // $manager->persist($subcat15);
        
        // $subcat16 = new SubCategoria();
        // $subcat16->setNombre('Elecciones');
        // $subcat16->setImagen('elecciones.png');
        // $subcat16->setCategoria($manager->merge($this->getReference('cat-politica')));
        // $manager->persist($subcat16);
        
        // $subcat17 = new SubCategoria();
        // $subcat17->setNombre('Diplomacia');
        // $subcat17->setImagen('diplomacia.png');
        // $subcat17->setCategoria($manager->merge($this->getReference('cat-politica')));
        // $manager->persist($subcat17);
        
        // $subcat18 = new SubCategoria();
        // $subcat18->setNombre('Dictadura');
        // $subcat18->setImagen('dictadura.png');
        // $subcat18->setCategoria($manager->merge($this->getReference('cat-politica')));
        // $manager->persist($subcat18);
        
        /******************* 
         * Economia
         *******************/
        // $subcat19 = new SubCategoria();
        // $subcat19->setNombre('Deuda');
        // $subcat19->setImagen('deuda.png');
        // $subcat19->setCategoria($manager->merge($this->getReference('cat-economia')));
        // $manager->persist($subcat19);
        
        // $subcat20 = new SubCategoria();
        // $subcat20->setNombre('Corrupción');
        // $subcat20->setImagen('corrupcion.png');
        // $subcat20->setCategoria($manager->merge($this->getReference('cat-economia')));
        // $manager->persist($subcat20);
        
        //$subcat21 = new SubCategoria();
        //$subcat21->setNombre('Trabajo');
        //$subcat21->setImagen('trabajo.png');
        //$subcat21->setCategoria($manager->merge($this->getReference('cat-economia')));
        //$manager->persist($subcat21);
        
        // $subcat22 = new SubCategoria();
        // $subcat22->setNombre('Energía');
        // $subcat22->setImagen('energia.png');
        // $subcat22->setCategoria($manager->merge($this->getReference('cat-economia')));
        // $manager->persist($subcat22);
        
        // $subcat23 = new SubCategoria();
        // $subcat23->setNombre('Finanzas');
        // $subcat23->setImagen('finanzas.png');
        // $subcat23->setCategoria($manager->merge($this->getReference('cat-economia')));
        // $manager->persist($subcat23);
        
        // $subcat24 = new SubCategoria();
        // $subcat24->setNombre('Privatización');
        // $subcat24->setImagen('privatizacion.png');
        // $subcat24->setCategoria($manager->merge($this->getReference('cat-economia')));
        // $manager->persist($subcat24);
        
        /******************* 
         * Ciencia
         *******************/
        // $subcat25 = new SubCategoria();
        // $subcat25->setNombre('Natural');
        // $subcat25->setImagen('natural.png');
        // $subcat25->setCategoria($manager->merge($this->getReference('cat-ciencia')));
        // $manager->persist($subcat25);
        
        // $subcat26 = new SubCategoria();
        // $subcat26->setNombre('Social');
        // $subcat26->setImagen('social.png');
        // $subcat26->setCategoria($manager->merge($this->getReference('cat-ciencia')));
        // $manager->persist($subcat26);
        
        // $subcat27 = new SubCategoria();
        // $subcat27->setNombre('Desarrollo');
        // $subcat27->setImagen('desarrollo.png');
        // $subcat27->setCategoria($manager->merge($this->getReference('cat-ciencia')));
        // $manager->persist($subcat27);
        
        // $subcat28 = new SubCategoria();
        // $subcat28->setNombre('Educación');
        // $subcat28->setImagen('educacion.png');
        // $subcat28->setCategoria($manager->merge($this->getReference('cat-ciencia')));
        // $manager->persist($subcat28);
        
        // $subcat29 = new SubCategoria();
        // $subcat29->setNombre('Investigación');
        // $subcat29->setImagen('investigacion.png');
        // $subcat29->setCategoria($manager->merge($this->getReference('cat-ciencia')));
        // $manager->persist($subcat29);
        
        // $subcat30 = new SubCategoria();
        // $subcat30->setNombre('Privatización');
        // $subcat30->setImagen('privatizacion.png');
        // $subcat30->setCategoria($manager->merge($this->getReference('cat-ciencia')));
        // $manager->persist($subcat30);
        
        /******************* 
         * Agrucultura
         *******************/
        // $subcat31 = new SubCategoria();
        // $subcat31->setNombre('Ganadería');
        // $subcat31->setImagen('ganadería.png');
        // $subcat31->setCategoria($manager->merge($this->getReference('cat-agricultura')));
        // $manager->persist($subcat31);
        
        // //$subcat32 = new SubCategoria();
        // //$subcat32->setNombre('Hambre');
        // //$subcat32->setImagen('hambre.png');
        // //$subcat32->setCategoria($manager->merge($this->getReference('cat-agricultura')));
        // //$manager->persist($subcat30);
        
        // $subcat33 = new SubCategoria();
        // $subcat33->setNombre('Nutrición');
        // $subcat33->setImagen('nutricion.png');
        // $subcat33->setCategoria($manager->merge($this->getReference('cat-agricultura')));
        // $manager->persist($subcat33);
        
        // $subcat34 = new SubCategoria();
        // $subcat34->setNombre('Propiedad');
        // $subcat34->setImagen('Propiedad.png');
        // $subcat34->setCategoria($manager->merge($this->getReference('cat-agricultura')));
        // $manager->persist($subcat34);
        
        // $subcat35 = new SubCategoria();
        // $subcat35->setNombre('Normativa');
        // $subcat35->setImagen('normativa.png');
        // $subcat35->setCategoria($manager->merge($this->getReference('cat-agricultura')));
        // $manager->persist($subcat35);
        
        // $subcat36 = new SubCategoria();
        // $subcat36->setNombre('Naturaleza');
        // $subcat36->setImagen('naturaleza.png');
        // $subcat36->setCategoria($manager->merge($this->getReference('cat-agricultura')));
        // $manager->persist($subcat36);
        
        /******************* 
         * Derechos humanos
         *******************/
        // $subcat37 = new SubCategoria();
        // $subcat37->setNombre('Guerra');
        // $subcat37->setImagen('guerra.png');
        // $subcat37->setCategoria($manager->merge($this->getReference('cat-derechos-humanos')));
        // $manager->persist($subcat37);
        
        // $subcat38 = new SubCategoria();
        // $subcat38->setNombre('Humanidad');
        // $subcat38->setImagen('humanidad.png');
        // $subcat38->setCategoria($manager->merge($this->getReference('cat-derechos-humanos')));
        // $manager->persist($subcat38);
        
        // $subcat39 = new SubCategoria();
        // $subcat39->setNombre('Violencia');
        // $subcat39->setImagen('violencia.png');
        // $subcat39->setCategoria($manager->merge($this->getReference('cat-derechos-humanos')));
        // $manager->persist($subcat39);
        
        // $subcat40 = new SubCategoria();
        // $subcat40->setNombre('Pobreza');
        // $subcat40->setImagen('pobreza.png');
        // $subcat40->setCategoria($manager->merge($this->getReference('cat-derechos-humanos')));
        // $manager->persist($subcat40);
        
        // $subcat41 = new SubCategoria();
        // $subcat41->setNombre('Hambre');
        // $subcat41->setImagen('hambre.png');
        // $subcat41->setCategoria($manager->merge($this->getReference('cat-derechos-humanos')));
        // $manager->persist($subcat41);
        
        // $subcat42 = new SubCategoria();
        // $subcat42->setNombre('Socioeconomía');
        // $subcat42->setImagen('socioeconomia.png');
        // $subcat42->setCategoria($manager->merge($this->getReference('cat-derechos-humanos')));
        // $manager->persist($subcat42);
        
        /******************* 
         * Cultura
         *******************/
        // $subcat43 = new SubCategoria();
        // $subcat43->setNombre('Internet');
        // $subcat43->setImagen('internet.png');
        // $subcat43->setCategoria($manager->merge($this->getReference('cat-cultura')));
        // $manager->persist($subcat43);
        
        // $subcat44 = new SubCategoria();
        // $subcat44->setNombre('Música');
        // $subcat44->setImagen('musica.png');
        // $subcat44->setCategoria($manager->merge($this->getReference('cat-cultura')));
        // $manager->persist($subcat44);
        
        // $subcat45 = new SubCategoria();
        // $subcat45->setNombre('Libros');
        // $subcat45->setImagen('libros.png');
        // $subcat45->setCategoria($manager->merge($this->getReference('cat-cultura')));
        // $manager->persist($subcat45);
        
        // $subcat46 = new SubCategoria();
        // $subcat46->setNombre('Cine');
        // $subcat46->setImagen('cine.png');
        // $subcat46->setCategoria($manager->merge($this->getReference('cat-cultura')));
        // $manager->persist($subcat46);
        
        // $subcat47 = new SubCategoria();
        // $subcat47->setNombre('Arte');
        // $subcat47->setImagen('arte.png');
        // $subcat47->setCategoria($manager->merge($this->getReference('cat-cultura')));
        // $manager->persist($subcat47);
        
        /******************* 
         * Sociedad
         *******************/
        // $subcat48 = new SubCategoria();
        // $subcat48->setNombre('Sanidad');
        // $subcat48->setImagen('sanidad.png');
        // $subcat48->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        // $manager->persist($subcat48);
        
        // $subcat49 = new SubCategoria();
        // $subcat49->setNombre('Protestas');
        // $subcat49->setImagen('protestas.png');
        // $subcat49->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        // $manager->persist($subcat49);
        
        // $subcat50 = new SubCategoria();
        // $subcat50->setNombre('Deshaucios');
        // $subcat50->setImagen('deshaucios.png');
        // $subcat50->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        // $manager->persist($subcat50);
        
        // $subcat51 = new SubCategoria();
        // $subcat51->setNombre('Deudas');
        // $subcat51->setImagen('deudas.png');
        // $subcat51->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        // $manager->persist($subcat51);
        
        // //$subcat52 = new SubCategoria();
        // //$subcat52->setNombre('Trabajo');
        // //$subcat52->setImagen('trabajo.png');
        // //$subcat52->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        // //$manager->persist($subcat52);
        
        // $subcat53 = new SubCategoria();
        // $subcat53->setNombre('Crecimiento');
        // $subcat53->setImagen('crecimiento.png');
        // $subcat53->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        // $manager->persist($subcat53);
        
        /******************* 
         * Blogs
         ******************
        $subcat54 = new SubCategoria();
        $subcat54->setNombre('Periodismo');
        $subcat54->setImagen('periodismo.png');
        $subcat54->setCategoria($manager->merge($this->getReference('cat-blogs')));
        $manager->persist($subcat54);
        
        $subcat55 = new SubCategoria();
        $subcat55->setNombre('Economía');
        $subcat55->setImagen('economia.png');
        $subcat55->setCategoria($manager->merge($this->getReference('cat-blogs')));
        $manager->persist($subcat55);
        
        $subcat56 = new SubCategoria();
        $subcat56->setNombre('Política');
        $subcat56->setImagen('politica.png');
        $subcat56->setCategoria($manager->merge($this->getReference('cat-blogs')));
        $manager->persist($subcat56);
        
        $subcat57 = new SubCategoria();
        $subcat57->setNombre('Educación');
        $subcat57->setImagen('educacion.png');
        $subcat57->setCategoria($manager->merge($this->getReference('cat-blogs')));
        $manager->persist($subcat57);
        
        $subcat58 = new SubCategoria();
        $subcat58->setNombre('Trabajo');
        $subcat58->setImagen('trabajo.png');
        $subcat58->setCategoria($manager->merge($this->getReference('cat-blogs')));
        $manager->persist($subcat58);
        
        $subcat59 = new SubCategoria();
        $subcat59->setNombre('Corrupción');
        $subcat59->setImagen('corrupcion.png');
        $subcat59->setCategoria($manager->merge($this->getReference('cat-blogs')));
        $manager->persist($subcat59);
        */
        
        
        
        
        /******************* 
         * Desinformacion
         *******************/
        // $subcat60 = new SubCategoria();
        // $subcat60->setNombre('Prensa');
        // $subcat60->setImagen('prensa.png');
        // $subcat60->setCategoria($manager->merge($this->getReference('cat-desinformacion')));
        // $manager->persist($subcat60);
        
        // $subcat61 = new SubCategoria();
        // $subcat61->setNombre('Televisión');
        // $subcat61->setImagen('television.png');
        // $subcat61->setCategoria($manager->merge($this->getReference('cat-desinformacion')));
        // $manager->persist($subcat61);
        
        // //$subcat62 = new SubCategoria();
        // //$subcat62->setNombre('Energía');
        // //$subcat62->setImagen('energía.png');
        // //$subcat62->setCategoria($manager->merge($this->getReference('cat-desinformacion')));
        // //$manager->persist($subcat62);
        
        // $subcat63 = new SubCategoria();
        // $subcat63->setNombre('Manipulación');
        // $subcat63->setImagen('manipulacion.png');
        // $subcat63->setCategoria($manager->merge($this->getReference('cat-desinformacion')));
        // $manager->persist($subcat63);
        
        // $subcat64 = new SubCategoria();
        // $subcat64->setNombre('Salud');
        // $subcat64->setImagen('salud.png');
        // $subcat64->setCategoria($manager->merge($this->getReference('cat-desinformacion')));
        // $manager->persist($subcat64);
        
        //$subcat65 = new SubCategoria();
        //$subcat65->setNombre('Guerra');
        //$subcat65->setImagen('guerra.png');
        //$subcat65->setCategoria($manager->merge($this->getReference('cat-desinformacion')));
        //$manager->persist($subcat65);
        
        
        $manager->flush();
        $this->AddReference('subcat-PHP', $subcat1);
        $this->AddReference('subcat-Symfony2', $subcat2);
        $this->AddReference('subcat-Javascript', $subcat3);
        $this->AddReference('subcat-jQuery', $subcat4);
        $this->AddReference('subcat-CSS3', $subcat5);
        $this->AddReference('subcat-HTML5', $subcat6);
        
        // $this->AddReference('subcat-cataluña', $subcat7);
        // $this->AddReference('subcat-galicia', $subcat8);
        // $this->AddReference('subcat-madrid', $subcat9);
        // $this->AddReference('subcat-pais-vasco', $subcat10);
        // $this->AddReference('subcat-valencia', $subcat11);
        // $this->AddReference('subcat-otras-comunidades', $subcat12);
        
        // $this->AddReference('subcat-congreso', $subcat13);
        // $this->AddReference('subcat-moncloa', $subcat14);
        // $this->AddReference('subcat-democracia', $subcat15);
        // $this->AddReference('subcat-elecciones', $subcat16);
        // $this->AddReference('subcat-diplomacia', $subcat17);
        // $this->AddReference('subcat-dictadura', $subcat18);
        
        // $this->AddReference('subcat-deuda', $subcat19);
        // $this->AddReference('subcat-corrupcion', $subcat20);
        // //$this->AddReference('subcat-trabajo', $subcat21);
        // $this->AddReference('subcat-energia', $subcat22);
        // $this->AddReference('subcat-finanzas', $subcat23);
        // $this->AddReference('subcat-privatizacion', $subcat24);
        
        // $this->AddReference('subcat-natural', $subcat25);
        // $this->AddReference('subcat-social', $subcat26);
        // $this->AddReference('subcat-desarrollo', $subcat27);
        // $this->AddReference('subcat-educacion', $subcat28);
        // $this->AddReference('subcat-investigacion', $subcat29);
        // //$this->AddReference('subcat-privatizacion', $subcat30);
        
        // $this->AddReference('subcat-ganaderia', $subcat31);
        // //$this->AddReference('subcat-hambre', $subcat32);
        // $this->AddReference('subcat-nutricion', $subcat33);
        // $this->AddReference('subcat-propiedad', $subcat34);
        // $this->AddReference('subcat-normativa', $subcat35);
        // $this->AddReference('subcat-naturaleza', $subcat36);
        
        // $this->AddReference('subcat-guerra', $subcat37);
        // $this->AddReference('subcat-humanidad', $subcat38);
        // $this->AddReference('subcat-violencia', $subcat39);
        // $this->AddReference('subcat-pobreza', $subcat40);
        // $this->AddReference('subcat-hambre', $subcat41);
        // $this->AddReference('subcat-socioeconomia', $subcat42);
        
        // $this->AddReference('subcat-internet', $subcat43);
        // $this->AddReference('subcat-musica', $subcat44);
        // $this->AddReference('subcat-libros', $subcat45);
        // $this->AddReference('subcat-cine', $subcat46);
        // $this->AddReference('subcat-arte', $subcat47);
        
        // $this->AddReference('subcat-sanidad', $subcat48);
        // $this->AddReference('subcat-protestas', $subcat49);
        // $this->AddReference('subcat-deshaucios', $subcat50);
        // $this->AddReference('subcat-deudas', $subcat51);
        // //$this->AddReference('subcat-trabajo', $subcat52);
        // $this->AddReference('subcat-crecimiento', $subcat53);
        
        // /*
        // $this->AddReference('subcat-periodismo', $subcat54);
        // $this->AddReference('subcat-economia', $subcat55);
        // $this->AddReference('subcat-politica', $subcat56);
        // $this->AddReference('subcat-educacion', $subcat57);
        // $this->AddReference('subcat-trabajo', $subcat58);
        // $this->AddReference('subcat-corrupcion', $subcat59);
        // */
        
        // $this->AddReference('subcat-prensa', $subcat60);
        // $this->AddReference('subcat-television', $subcat61);
        // //$this->AddReference('subcat-energia', $subcat62);
        // $this->AddReference('subcat-manipulacion', $subcat63);
        // $this->AddReference('subcat-salud', $subcat64);
        // //$this->AddReference('subcat-guerra', $subcat65);
        
        
    }
}
?>
