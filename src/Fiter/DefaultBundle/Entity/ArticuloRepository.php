<?php

namespace Fiter\DefaultBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticuloRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticuloRepository extends EntityRepository{

    public function findAllByLocale($locale = 'es'){
        //Make a Select query
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            //->from('FiterDefaultBundle:Articulo', 'o')
            ->orderBy('a.fechaPublicacion', 'DESC');
      

        // Use Translation Walker
        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        // Force the locale
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            //$locale
            'es'
        );
        //fallback
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
            1
        );

        return $query->getResult();
        //return $query->getArrayResult();
    }

    public function findOneByIdAndLocale($id, $locale = 'es'){
        //Make a Select query
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            //->from('FiterDefaultBundle:Articulo', 'o')
            ->where('a.id = :id')
            ->orderBy('a.fechaPublicacion', 'DESC')
            ->setParameter('id', $id)
            ;

        // Use Translation Walker
        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        // Force the locale
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );
        //fallback
        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
            1
        );

        return $query->getResult();
        //return $query->getArrayResult();
    }

    public function findTodosLosArticulosDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            ORDER BY o.fechaPublicacion DESC');
        return $consulta;
    }
    public function findTodosLosArticulos(){
        return $this->findTodosLosArticulosDQL()->getResult();
    }
    public function findTodosLosArticulosActivosDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            WHERE o.activo = true
            ORDER BY o.fechaPublicacion DESC');
        return $consulta;
    }
    public function findTodosLosArticulosActivos(){
        return $this->findTodosLosArticulosActivosDQL()->getResult();
    }
    public function findAllArticulosActivosCategoriaDQL($slug){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            JOIN o.categoria c
            WHERE c.slug = :slug AND
            o.activo = true
            ORDER BY o.fechaPublicacion DESC
            ');
        $consulta->setParameter('slug', $slug);
        return $consulta;
    }
    public function findAllArticulosActivosCategoria($slug){
        return $this->findAllArticulosActivosCategoriaDQL($slug)->getResult();
    }
    public function findAllArticulosActivosSubCategoriaDQL($slug){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            JOIN o.subCategoria c
            WHERE c.slug = :slug AND
            o.activo = true
            ORDER BY o.fechaPublicacion DESC
            ');
        $consulta->setParameter('slug', $slug);
        return $consulta;
    }
    public function findAllArticulosActivosSubCategoria($slug){
        return $this->findAllArticulosActivosSubCategoriaDQL($slug)->getResult();
    }
    public function findAllArticulosCategoriaDQL($slug){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            JOIN o.categoria c
            WHERE c.slug = :slug 
            ORDER BY o.fechaPublicacion DESC
            ');
        $consulta->setParameter('slug', $slug);
        return $consulta;
    }
    public function findAllArticulosCategoria($slug){
        return $this->findAllArticulosCategoriaDQL($slug)->getResult();
    }
    public function findListaMasVistosDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            WHERE o.activo=true
            ORDER BY o.visitas DESC')->setMaxResults(7);;
        return $consulta;
    }
    public function findListaMasVistos(){
        return $this->findListaMasVistosDQL()->getResult();
    }
    public function findListaMasValoradosDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            WHERE o.activo=true
            ORDER BY o.likes DESC')->setMaxResults(7);;
        return $consulta;
    }
    public function findListaMasValorados(){
        return $this->findListaMasValoradosDQL()->getResult();
    }
    public function findListaActualizacionesDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            WHERE o.fechaPublicacion != o.fechaActualizacion 
            AND o.activo=true
            ORDER BY o.fechaActualizacion DESC')->setMaxResults(7);
        return $consulta;
    }
    public function findListaActualizaciones(){
        return $this->findListaActualizacionesDQL()->getResult();
    }
    public function findListaRelacionadosDQL($slug){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            JOIN o.categoria c
            WHERE c.slug = :slug
            AND o.activo=true
            ORDER BY o.fechaPublicacion DESC
            ');
        $consulta->setParameter('slug', $slug)->setMaxResults(7);
        return $consulta;
    }
    public function findListaRelacionados($slug){
        if($slug=="inicio")
            return $this->findListaMasVistosDQL()->getResult();
        else
            return $this->findListaRelacionadosDQL($slug)->getResult();
    }
    public function findAllArticulosUsuarioDQL($nombre){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o,u FROM FiterDefaultBundle:Articulo o
            JOIN o.usuario c
            JOIN o.categoria u
            WHERE c.username = :nombre
            ORDER BY o.fechaPublicacion DESC
            ');
        $consulta->setParameter('nombre', $nombre);
        return $consulta;
    }
    public function findAllArticulosUsuario($nombre){
        return $this->findAllArticulosUsuarioDQL($nombre)->getResult();
    }
    public function findTodosLosArticulosInactivosDQL(){
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o FROM FiterDefaultBundle:Articulo o
            WHERE o.activo = false
            ORDER BY o.fechaPublicacion DESC');
        return $consulta;
    }
    public function findTodosLosArticulosInactivos(){
        return $this->findTodosLosArticulosInactivosDQL()->getResult();
    }  
}
