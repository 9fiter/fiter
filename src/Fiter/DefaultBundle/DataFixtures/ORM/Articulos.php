<?php

namespace Fiter\DefaultBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fiter\DefaultBundle\Entity\Articulo;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

//use Fiter\DefaultBundle\Entity\Translation;

class Articulos extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    /**
     * @var ContainerInterface
     */
    private $container;
    public function setContainer(ContainerInterface $container = null){
      $this->container = $container;
    }
    public function getOrder(){ return 3; }
    public function load(ObjectManager $manager)    {
        
        $articulo=array();
        
        $articulo[1] = new Articulo();
        $articulo[1]->setUsuario($this->getReference('usr-moi'));
        $articulo[1]->setActivo(true);
        $articulo[1]->setTitulo('Contenidos traducibles a varios idiomas');
        $articulo[1]->setContenido('   
            <p>El contenido de este artículo está traducido a los idiomas galego, catalan, español e inglés.</p>
            <p>Se muestra siempre el contenido traducido en el idioma seleccionado para visualizar la página web.</p>
            <p>En caso de que no exista traduccion para el idioma seleccionado, el contenido será mostrado en el idioma por defecto.</p>
        ');
        $articulo[1]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[1]->setCategoria($manager->merge($this->getReference('cat-programacion')));
        //$articulo[1]->setCategoria($manager->merge($this->getReference('cat-economia')));
        $articulo[1]->setSubCategoria($manager->merge($this->getReference('subcat-PHP')));
        $articulo[1]->setPath('6a8559a6f132e4476dc613e494ec536883955768.jpeg');
        $articulo[1]->setVisitas(148575);

        //$articulo[1]->addTranslation(new ArticuloTranslation('en', 'titulo', 'En inglés'));
        //$articulo[1]->setTranslatableLocale('es');
        $manager->persist($articulo[1]);
        $manager->flush();
        
            $articulo[1]->setTitulo('Translatable content into several languages');
            $articulo[1]->setContenido('   
                <p>The content of this article is translated into the Galician, Catalan, Spanish and English languages.</p>
                <p>Content displayed is always translated in the selected language for display the web page.</p>
                <p>If there is no translation for the selected language, content will be displayed in default language.</p>
            ');
            $articulo[1]->setTranslatableLocale('en');
            $manager->persist($articulo[1]);
            $manager->flush();

            $articulo[1]->setTitulo('Contidos traducibles a varios idiomas');
            $articulo[1]->setContenido('   
                <p>O contido de este artigo está traducido os idiomas galego, catalan, español e inglés.</p>
                <p>Mostrase sempre o contido traducido o idioma seleccionado para visualizar a páxina web.</p>
                <p>No caso de que non exista traducción para o idioma seleccionado, o contido será mostrado no idioma por defecto.</p>
            ');
            $articulo[1]->setTranslatableLocale('gl');
            $manager->persist($articulo[1]);
            $manager->flush();

            $articulo[1]->setTitulo('Continguts traduïbles a diversos idiomes');
            $articulo[1]->setContenido("   
                <p>El contingut d'aquest article està traduït als idiomes gallec, català, espanyol i anglès.</p>
                <p>Es mostra sempre el contingut traduït en l'idioma seleccionat per a visualitzar la pàgina web.</p>
                <p>En cas que no existeixi traducció de l'idioma seleccionat, el contingut serà mostrat en l'idioma per defecte.</p>
            ");
            $articulo[1]->setTranslatableLocale('ca');
            $manager->persist($articulo[1]); 
            $manager->flush();










        
        $articulo[2] = new Articulo();
        $articulo[2]->setUsuario($this->getReference('usr-anon'));
        $articulo[2]->setActivo(true);
        $articulo[2]->setTitulo('Rutas internacionalizadas');
        $articulo[2]->setContenido('
            <p>Como podrás observar, las rutas de la aplicación, además de ser totalmente descriptivas, son traducidas al idioma seleccionado para visualizar la página web. Esto es posible gracias al bundle BeSimpleI18nRoutingBundle evita hacerte copiar y pegar las rutas para diferentes idiomas y adicionalmente permite traducir determinados parámetros de enrutamiento a diferentes idiomas mediante un backend de traducción ya sea mediante Symfony o Doctrine DBAL + cache.</p>
        ');
        //$articulo[2]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[2]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[2]->setCategoria($manager->merge($this->getReference('cat-programacion')));
        //$articulo[2]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $articulo[2]->setPath('629d3c1d966f2ee59675f1de00fae2673b583d21.jpeg');
        $articulo[2]->setVisitas(54246);
        //$articulo[2]->setTranslatableLocale('es');
        $manager->persist($articulo[2]);
        $manager->flush();
        
            $articulo[2]->setTitulo('Routes internationalized');
            $articulo[2]->setContenido('   
                <p>As you can see, the application routes, besides being totally descriptive, are translated to the selected language to display the web page. This is possible thanks to the bundle BeSimpleI18nRoutingBundle prevents copying and pasting make routes for different languages ​​and additionally allows translate certain routing parameters ​into different languages using either a Symfony Translator or a Doctrine DBAL (+Cache) based backend.</p>
            ');
            $articulo[2]->setTranslatableLocale('en');
            $manager->persist($articulo[2]);
            $manager->flush();

            $articulo[2]->setTitulo('Rutas internacionalizadas');
            $articulo[2]->setContenido('   
                <p>Como podras observar, as rutas da aplicacion, ademais de ser totalmente descriptivas, son traducidas o idioma seleccionado para visualizar a páxina web. Isto é posible grazas o bundle BeSimpleI18nRoutingBundle que evita facerte copiar e pegar a rutas para diferentes idiomas e adicionalmente permite traducir determinados parámetros de enrutamento a diferentes idiomas mediante un backend de traducción sexa mediante Symfony o Doctrine DBAL + cache.</p>
            ');
            $articulo[2]->setTranslatableLocale('gl');
            $manager->persist($articulo[2]);
            $manager->flush();

            $articulo[2]->setTitulo('Rutes internacionalitzades');
            $articulo[2]->setContenido("   
                <p>Com podràs observar, les Rutes de l'Aplicació, a més de serveis Totalment descriptives, fill traduïda a l'idioma Seleccionat per a visualitzar la pàgina web. Això És Possible gràcies al paquet BeSimpleI18nRoutingBundle evita fer-te copiar i enganxar les rutes paràgraf diferents idiomes i addicionalment permet translate determinats llista de paràmetres d'enrutament d'un diferents idiomes sense backend de traducció ia mar mijançant Symfony o Doctrina DBAL + cache.</p>
            ");
            $articulo[2]->setTranslatableLocale('ca');
            $manager->persist($articulo[2]); 
            $manager->flush();
        
        $articulo[3] = new Articulo();
        $articulo[3]->setUsuario($this->getReference('usr-anon'));
        $articulo[3]->setActivo(true);
        $articulo[3]->setTitulo('Diseño adaptable a todo tipo de dispositivos');
        $articulo[3]->setContenido('   
            <p>Este sitio web utiliza HTML5 y está construida sobre la base HTML5-Boilerplate, apoyandose en twig, un motor de plantillas para php y utilizando las técnicas mobile first y responsive web design para permitir un diseño adaptable a todo tipo de dispositivos, desde smartphones a ordenadores de escritorio pasando por tablets e incluso se adapta a los futuros dispositivos.</p>            
        ');
        $articulo[3]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[3]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[3]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[3]->setCategoria($manager->merge($this->getReference('cat-historia')));
        $articulo[3]->setPath('5969b9b7275c2c709f3ae9aa82821db498ae58d3.png');
        $articulo[3]->setVisitas(314246);
        $manager->persist($articulo[3]);
        $manager->flush();


            $articulo[3]->setTitulo('Design adaptable to all devices types');
            $articulo[3]->setContenido('   
                <p>This site uses HTML5 and is built on HTML5-Boilerplate, leaning on twig, a template engine for php and using the mobile first and responsive web design techniques to allow a design adaptable to all kinds of devices, from smartphones to computers desktop via tablets and even fits future devices.</p>
            ');
            $articulo[3]->setTranslatableLocale('en');
            $manager->persist($articulo[3]);
            $manager->flush();

            $articulo[3]->setTitulo('Deseño adaptable a todo tipo de dispositivos');
            $articulo[3]->setContenido('   
                <p>Este sitio web utiliza HTML5 e está construída sobre a base HTML5-Boilerplate, apoiandose en twig, un motor de plantillas para php e utilizando as técnicas mobile first e responsive web design para permitir un deseño adaptable a todo tipo de dispositivos, dende smartphones a ordenadores de escritorio pasando por tablets e ademais adaptase aos futuros dispositivos.</p>
            ');
            $articulo[3]->setTranslatableLocale('gl');
            $manager->persist($articulo[3]);
            $manager->flush();

            $articulo[3]->setTitulo('Disseny adaptable a tot tipus de dispositius');
            $articulo[3]->setContenido("   
                <p>Aquest lloc web utilitza HTML5 i està construïda sobre la base HTML5-Boilerplate, recolzant-se en twig, un motor de plantilles per php i utilitzant les tècniques mobile first i responsive web design per permetre un disseny adaptable a tot tipus de dispositius, des de smartphones a ordinadors d'escriptori passant per tablets i fins i tot s'adapta als futurs dispositius.</p>
            ");
            $articulo[3]->setTranslatableLocale('ca');
            $manager->persist($articulo[1]); 
            $manager->flush();

        







        // $articulo[4] = new Articulo();
        // $articulo[4]->setUsuario($this->getReference('usr-anon'));
        // $articulo[4]->setActivo(true);
        // $articulo[4]->setTitulo('Phasellus condimentum dignissim tincidunt');
        // $articulo[4]->setContenido('   
        //     <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        //     <p>Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. <i>Praesent libero</i>. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <i>Curabitur sodales ligula in libero</i>. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. <b>Maecenas mattis</b>. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. </p>
        //     <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. <b>Ut fringilla</b>. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. </p>
        //     <p>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. <i>Nunc feugiat mi a tellus consequat imperdiet</i>. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. <b>Morbi in ipsum sit amet pede facilisis laoreet</b>. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. </p>
        //     <p>Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. <i>Morbi in ipsum sit amet pede facilisis laoreet</i>. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. <b>Cras metus</b>. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. </p>
        // ');
        // $articulo[4]->setCategoria($manager->merge($this->getReference('cat-religion')));
        // //$articulo[4]->setPath('2d85b84921d59b3b3b2d95d0004394cd6dcef403.jpeg');
        
        // $articulo[4]->setVisitas(274255);
        // $manager->persist($articulo[4]);
        
        $articulo[5] = new Articulo();
        $articulo[5]->setUsuario($this->getReference('usr-anon'));
        $articulo[5]->setActivo(true);
        $articulo[5]->setTitulo('Ut sed massa sit amet justo tincidunt luctus');
        $articulo[5]->setContenido('   
            <p>Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. <b>Quisque volutpat condimentum velit</b>. Nunc feugiat mi a tellus consequat imperdiet. <b>Fusce ac turpis quis ligula lacinia aliquet</b>. Vestibulum sapien. Proin quam. Etiam ultrices. <i>Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa</i>. Suspendisse in justo eu magna luctus suscipit. </p>
            <p>Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. <b>Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam</b>. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. </p>
            <p>Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Integer lacinia sollicitudin massa</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. </p>
            <p>Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. <b>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede</b>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. <b>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo</b>. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. <i>Nulla quam</i>. Fusce nec tellus sed augue semper porta. </p>
            <p>Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Nulla quis sem at nibh elementum imperdiet</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. <b>Mauris massa</b>. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. <i>Nulla quis sem at nibh elementum imperdiet</i>. Fusce ac turpis quis ligula lacinia aliquet. </p>
            <p>Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. <b>Sed convallis tristique sem</b>. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. <i>Fusce nec tellus sed augue semper porta</i>. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. </p>
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. </p>
            <p>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. <b>Suspendisse in justo eu magna luctus suscipit</b>. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. <b>Sed non quam</b>. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. </p>
            <p>Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. <b>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo</b>. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p>
        ');
        $articulo[5]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[5]->setPath('1e4349101152c4ea61ba54f0198d121a82c5ef29.jpeg');
        $articulo[5]->setVisitas(574746);
        $manager->persist($articulo[5]);
        
        $articulo[6] = new Articulo();
        $articulo[6]->setUsuario($this->getReference('usr-anon'));
        $articulo[6]->setActivo(true);
        $articulo[6]->setTitulo('Morbi vitae urna lectus, non aliquet odio. In sit amet imperdiet arcu');
        $articulo[6]->setContenido('   
            <p>Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. <i>Sed cursus ante dapibus diam</i>. Proin ut ligula vel nunc egestas porttitor. <b>Curabitur tortor</b>. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. <i>Mauris massa</i>. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. <b>Sed dignissim lacinia nunc</b>. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. </p>
            <p>Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. <b>Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis</b>. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. </p>
            <p>Praesent blandit dolor. <i>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos</i>. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. <b>Etiam ultrices</b>. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. </p>
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. <b>Proin sodales libero eget ante</b>. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. <i>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede</i>. Vestibulum lacinia arcu eget nulla. </p>
            <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. <b>Mauris massa</b>. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. </p>
            <p>Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. <i>Pellentesque nibh</i>. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. </p>
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. <i>Pellentesque nibh</i>. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. <b>Nunc feugiat mi a tellus consequat imperdiet</b>. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. <i>Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa</i>. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. </p>
            <p>Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. </p>
            <p>Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. <b>Morbi mi</b>. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
        ');
        $articulo[6]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        // $articulo[6]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[6]->setPath('3a33e8efee8e887459e8ba0f11d00368410cb05f.jpeg');
        $manager->persist($articulo[6]);
        
        $articulo[7] = new Articulo();
        $articulo[7]->setUsuario($this->getReference('usr-anon'));
        $articulo[7]->setActivo(true);
        $articulo[7]->setTitulo('Phasellus bibendum metus nec elit sodales ac semper dolor commodo');
        $articulo[7]->setContenido('   
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. </p>
            <p>Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. <i>Proin quam</i>. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. </p>
            <p>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. <b>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede</b>. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. </p>
            <p>Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. <i>Ut eu diam at pede suscipit sodales</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Sed cursus ante dapibus diam</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. <i>Nulla quam</i>. Pellentesque nibh. Aenean quam. </p>
        ');
        $articulo[7]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[7]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[7]->setPath('f53457386d41b8957f3b9efc35b813dc7d01d766.jpeg');
        $manager->persist($articulo[7]);
        
        $articulo[8] = new Articulo();
        $articulo[8]->setUsuario($this->getReference('usr-anon'));
        $articulo[8]->setActivo(true);
        $articulo[8]->setTitulo('Vivamus consectetur malesuada ligula, et congue nunc scelerisque');
        $articulo[8]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. <b>Integer lacinia sollicitudin massa</b>. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. <b>Nulla facilisi</b>. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. </p>
            <p>Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. <b>Sed pretium blandit orci</b>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. <b>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo</b>. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. </p>
            <p>Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. </p>
            <p><i>Praesent mauris</i>. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. <i>Proin ut ligula vel nunc egestas porttitor</i>. Vestibulum sapien. Proin quam. Etiam ultrices. </p>
            <p>Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. </p>
            <p>Curabitur sit amet mauris. <b>Sed non quam</b>. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. </p>
            <p>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. <b>Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue</b>. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. <b>Ut eu diam at pede suscipit sodales</b>. Praesent libero. Sed cursus ante dapibus diam. </p>
        ');
        $articulo[8]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[8]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[8]->setCategoria($manager->merge($this->getReference('cat-sociedad')));
        //$articulo[8]->setPath('477b906ab571134ae8ba89deb7968272a8c42ded.jpeg');
        $manager->persist($articulo[8]);
        
        $articulo[9] = new Articulo();
        $articulo[9]->setUsuario($this->getReference('usr-anon'));
        $articulo[9]->setActivo(true);
        $articulo[9]->setTitulo('Praesent placerat rhoncus nulla, a porttitor justo imperdiet ut');
        $articulo[9]->setContenido('   
            <p>Praesent mauris. Fusce nec tellus sed augue semper porta. <b>Praesent libero</b>. Mauris massa. <i>Sed aliquet risus a tortor</i>. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. </p>
            <p><b>Mauris massa</b>. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. <b>Aenean quam</b>. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. <i>Pellentesque nibh</i>. Ut fringilla. </p>
            <p>Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. </p>
            <p>In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. </p>
        ');
        $articulo[9]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[9]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[9]->setPath('a3a547136d2ae9fc866b8a87b0a41a3c8eed43bb.jpeg');
        $manager->persist($articulo[9]);
        
        $articulo[10] = new Articulo();
        $articulo[10]->setUsuario($this->getReference('usr-anon'));
        $articulo[10]->setActivo(true);
        $articulo[10]->setTitulo('Quisque vulputate, urna nec rhoncus sagittis');
        $articulo[10]->setContenido('   
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. </p>
            <p>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. <b>Suspendisse in justo eu magna luctus suscipit</b>. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. <b>Sed non quam</b>. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. </p>
            <p>Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. <b>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo</b>. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p>
            <p>Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. <b>Vivamus consectetuer risus et tortor</b>. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. </p>
            <p>Aenean quam. In scelerisque sem at dolor. <i>Sed cursus ante dapibus diam</i>. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. <i>Lorem ipsum dolor sit amet, consectetur adipiscing elit</i>. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
            <p>Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. </p>
            <p>Integer euismod lacus luctus magna. <b>Ut fringilla</b>. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. <i>Nam nec ante</i>. Praesent blandit dolor. Sed non quam. <b>Vestibulum sapien</b>. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. <b>Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam</b>. Curabitur sit amet mauris. </p>
            <p>Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. </p>
            <p>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. <b>Integer lacinia sollicitudin massa</b>. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. <b>Sed pretium blandit orci</b>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p>
            <p>Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. <i>Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. <b>Praesent libero</b>. Sed dignissim lacinia nunc. Curabitur tortor. </p>
        ');
        $articulo[10]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[10]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[10]->setPath('45d9388ebf7f3591e617534b54223d6ad3d5c227.jpeg');
        $manager->persist($articulo[10]);
        
        $articulo[11] = new Articulo();
        $articulo[11]->setUsuario($this->getReference('usr-anon'));
        $articulo[11]->setActivo(true);
        $articulo[11]->setTitulo('Nullam sed ipsum dui, nec rutrum nisl. Integer sed eros nunc, at tincidunt arcu');
        $articulo[11]->setContenido('   
            <p>Ut fringilla. <b>Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh</b>. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. </p>
            <p>Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. <i>Mauris ipsum</i>. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. <b>Sed non quam</b>. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. </p>
            <p>Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. <b>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede</b>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. </p>
            <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. <b>Mauris massa</b>. Maecenas mattis. <i>Duis sagittis ipsum</i>. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. </p>
            <p><b>Curabitur tortor</b>. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. <i>Fusce nec tellus sed augue semper porta</i>. Vestibulum sapien. </p>
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. </p>
            <p>Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. <i>Proin quam</i>. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. </p>
        ');
        $articulo[11]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[11]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[11]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[11]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[11]->setPath('7cac3ab927d33d3ae7595be1df972d49e70f5e75.jpeg');
        
        $manager->persist($articulo[11]);
        
        $articulo[12] = new Articulo();
        $articulo[12]->setUsuario($this->getReference('usr-anon'));
        $articulo[12]->setActivo(true);
        $articulo[12]->setTitulo('Sed luctus massa in nibh placerat et suscipit metus adipiscing');
        $articulo[12]->setContenido('   
            <p>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Vivamus consectetuer risus et tortor</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. </p>
            <p>Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. <i>Mauris ipsum</i>. Sed lectus. </p>
            <p><b>Quisque volutpat condimentum velit</b>. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. <b>Ut fringilla</b>. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. <i>Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis</i>. Ut ultrices ultrices enim. Curabitur sit amet mauris. </p>
            <p>Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. <i>Sed lectus</i>. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. <b>Integer lacinia sollicitudin massa</b>. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Sed aliquet risus a tortor</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. <i>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</i>. Sed pretium blandit orci. </p>
            <p>Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. <i>Integer lacinia sollicitudin massa</i>. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. <i>Integer lacinia sollicitudin massa</i>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. </p>
            <p>Praesent mauris. <b>Lorem ipsum dolor sit amet, consectetur adipiscing elit</b>. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. <i>Nulla ut felis in purus aliquam imperdiet</i>. Aenean quam. <b>Vestibulum lacinia arcu eget nulla</b>. In scelerisque sem at dolor. Maecenas mattis. </p>
            <p>Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. <i>Sed nisi</i>. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. </p>
            <p>Vestibulum sapien. <b>Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh</b>. Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. <b>Suspendisse potenti</b>. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. <b>Suspendisse in justo eu magna luctus suscipit</b>. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. <i>Mauris ipsum</i>. Vestibulum tincidunt malesuada tellus. </p>
        ');
        $articulo[12]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $manager->persist($articulo[12]);
        
        
        
        
        $articulo[13] = new Articulo();
        $articulo[13]->setUsuario($this->getReference('usr-anon'));
        $articulo[13]->setActivo(true);
        $articulo[13]->setTitulo('Sed aliquet risus a tortor. Integer id quam');
        $articulo[13]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[13]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[13]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        //$articulo[13]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $articulo[13]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[13]->setPath('0d805b2fa99618b5d9f804db5334499a549911e2.jpeg');
        $manager->persist($articulo[13]);
        
        
        $articulo[14] = new Articulo();
        $articulo[14]->setUsuario($this->getReference('usr-anon'));
        $articulo[14]->setActivo(true);
        $articulo[14]->setTitulo('Suspendisse quis neque nulla, sed ultricies eros');
        $articulo[14]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[14]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $articulo[14]->setPath('756fda04e49790e23bee49de4a8ea9b360d21691.jpeg');
        $manager->persist($articulo[14]);
        
        $articulo[15] = new Articulo();
        $articulo[15]->setUsuario($this->getReference('usr-anon'));
        $articulo[15]->setActivo(true);
        $articulo[15]->setTitulo('Nam non tellus urna, eu pellentesque augue');
        $articulo[15]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[15]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[15]->setPath('52d1e95daad6800d672c50cc2707b77d5d20b32d.jpeg');
        $manager->persist($articulo[15]);
        
        $articulo[16] = new Articulo();
        $articulo[16]->setUsuario($this->getReference('usr-anon'));
        $articulo[16]->setActivo(true);
        $articulo[16]->setTitulo('Maecenas aliquam arcu at ante faucibus et vestibulum risus lobortis');
        $articulo[16]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[16]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $manager->persist($articulo[16]);
        
        $articulo[17] = new Articulo();
        $articulo[17]->setUsuario($this->getReference('usr-anon'));
        $articulo[17]->setActivo(true);
        $articulo[17]->setTitulo('Proin sodales libero eget ante mauris massa');
        $articulo[17]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[17]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[17]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[17]->setPath('45eb3bf7dd0427bc36928406c66624d09019c4b2.jpeg');
        $manager->persist($articulo[17]);
        
        $articulo[18] = new Articulo();
        $articulo[18]->setUsuario($this->getReference('usr-anon'));
        $articulo[18]->setActivo(true);
        $articulo[18]->setTitulo('Maecenas aliquet mollis lectus');
        $articulo[18]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[18]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[18]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[18]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[18]->setPath('6458c64be2dd40c022cb5d09b202af85690dc7fd.jpeg');
        $manager->persist($articulo[18]);
        
        $articulo[19] = new Articulo();
        $articulo[19]->setUsuario($this->getReference('usr-anon'));
        $articulo[19]->setActivo(true);
        $articulo[19]->setTitulo('Pellentesque habitant morbi tristique senectus et netus');
        $articulo[19]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[19]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[19]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[19]->setPath('956300b4d8713efced1feece512d6b9d434bec65.png');
        $manager->persist($articulo[19]);
        
        $articulo[20] = new Articulo();
        $articulo[20]->setUsuario($this->getReference('usr-anon'));
        $articulo[20]->setActivo(true);
        $articulo[20]->setTitulo('Aenean quam scelerisque sem at dolor');
        $articulo[20]->setContenido('
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <i>Proin sodales libero eget ante</i>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. </p>
            <p>Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. </p>
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam. Etiam ultrices. <b>Mauris ipsum</b>. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. </p>
            <p>Non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. <b>Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam</b>. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. <b>Suspendisse in justo eu magna luctus suscipit</b>. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. <b>Morbi in ipsum sit amet pede facilisis laoreet</b>. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[20]->setFechaPublicacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[20]->setFechaActualizacion(new \DateTime("2011-07-23 06:15:20"));
        $articulo[20]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[20]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[20]->setPath('ac3ea53635b2001d99617292adb2ba840c2fbb00.jpeg');
        $manager->persist($articulo[20]);
        
        $articulo[21] = new Articulo();
        $articulo[21]->setUsuario($this->getReference('usr-anon'));
        $articulo[21]->setActivo(true);
        $articulo[21]->setTitulo('Nunc nec tortor a odio elementum viverra nec vel justo');
        $articulo[21]->setContenido('   
            <p>Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Curabitur sit amet mauris</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. <b>Proin sodales libero eget ante</b>. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. </p>
            <p>Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. </p>
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
        ');
        $articulo[21]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $manager->persist($articulo[21]);
        
        $articulo[22] = new Articulo();
        $articulo[22]->setUsuario($this->getReference('usr-anon'));
        $articulo[22]->setActivo(true);
        $articulo[22]->setTitulo('Phasellus condimentum dignissim tincidunt');
        $articulo[22]->setContenido('   
            <p><i>Proin sodales libero eget ante</i>. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Praesent libero</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. </p>
            <p>Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. <i>Praesent libero</i>. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <i>Curabitur sodales ligula in libero</i>. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. <b>Maecenas mattis</b>. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. </p>
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. <b>Ut fringilla</b>. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. </p>
            <p>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. <i>Nunc feugiat mi a tellus consequat imperdiet</i>. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. <b>Morbi in ipsum sit amet pede facilisis laoreet</b>. Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. </p>
            <p>Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. <i>Morbi in ipsum sit amet pede facilisis laoreet</i>. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. <b>Cras metus</b>. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. </p>
        ');
        $articulo[22]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        //$articulo[22]->setPath('e13239d742824ddeadb341edeb710a4d78d0e9df.jpeg');
        $manager->persist($articulo[22]);
        
        $articulo[23] = new Articulo();
        $articulo[23]->setUsuario($this->getReference('usr-anon'));
        $articulo[23]->setActivo(true);
        $articulo[23]->setTitulo('Ut sed massa sit amet justo tincidunt luctus');
        $articulo[23]->setContenido('   
            <p>Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. <b>Quisque volutpat condimentum velit</b>. Nunc feugiat mi a tellus consequat imperdiet. <b>Fusce ac turpis quis ligula lacinia aliquet</b>. Vestibulum sapien. Proin quam. Etiam ultrices. <i>Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa</i>. Suspendisse in justo eu magna luctus suscipit. </p>
            <p>Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. <b>Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam</b>. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. </p>
            <p>Integer lacinia sollicitudin massa. Cras metus. Sed aliquet risus a tortor. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. <b>Integer lacinia sollicitudin massa</b>. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. </p>
            <p>Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. Vivamus consectetuer risus et tortor. <b>Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede</b>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. <b>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo</b>. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. <i>Nulla quam</i>. Fusce nec tellus sed augue semper porta. </p>
            <p>Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. <b>Nulla quis sem at nibh elementum imperdiet</b>. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. <b>Mauris massa</b>. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. <i>Nulla quis sem at nibh elementum imperdiet</i>. Fusce ac turpis quis ligula lacinia aliquet. </p>
            <p>Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. <b>Sed convallis tristique sem</b>. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante. Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. <i>Fusce nec tellus sed augue semper porta</i>. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. </p>
            <p>Proin quam. Etiam ultrices. Suspendisse in justo eu magna luctus suscipit. Sed lectus. Integer euismod lacus luctus magna. Quisque cursus, metus vitae pharetra auctor, sem massa mattis sem, at interdum magna augue eget diam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi lacinia molestie dui. Praesent blandit dolor. Sed non quam. In vel mi sit amet augue congue elementum. Morbi in ipsum sit amet pede facilisis laoreet. </p>
            <p>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim. <b>Suspendisse in justo eu magna luctus suscipit</b>. Curabitur sit amet mauris. Morbi in dui quis est pulvinar ullamcorper. Nulla facilisi. Integer lacinia sollicitudin massa. <b>Sed non quam</b>. Cras metus. Sed aliquet risus a tortor. <b>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue</b>. Integer id quam. Morbi mi. Quisque nisl felis, venenatis tristique, dignissim in, ultrices sit amet, augue. Proin sodales libero eget ante. Nulla quam. </p>
            <p>Aenean laoreet. Vestibulum nisi lectus, commodo ac, facilisis ac, ultricies eu, pede. Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo. Sed pretium blandit orci. Ut eu diam at pede suscipit sodales. Aenean lectus elit, fermentum non, convallis id, sagittis at, neque. Nullam mauris orci, aliquet et, iaculis et, viverra vitae, ligula. Nulla ut felis in purus aliquam imperdiet. Maecenas aliquet mollis lectus. <b>Ut orci risus, accumsan porttitor, cursus quis, aliquet eget, justo</b>. Vivamus consectetuer risus et tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. </p>
        ');
        $articulo[23]->setCategoria($manager->merge($this->getReference('cat-diseñoweb')));
        $manager->persist($articulo[23]);
        
        
        $manager->flush();
        
        
        
        
        foreach ($articulo as $x=> $value) {
            // create the ACL for $articulo1
            $aclProvider = $this->container->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($articulo[$x]);
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