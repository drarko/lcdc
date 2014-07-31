<?php

namespace Annotations\Doctrine;

use Doctrine\ORM\EntityRepository;

class Repository extends EntityRepository {

    public function findLikeBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $qb->select( 'entity' )
            ->from( $this->getEntityName(), 'entity' );

        foreach ( $criteria as $field => $value ) {
	  if($value != null) {
            $qb->andWhere( $expr->like( 'entity.' . $field, "'%".$value."%'" ) );
          }
        }

        if ( $orderBy ) {

            foreach ( $orderBy as $field => $order ) {

                $qb->addOrderBy( 'entity.' . $field, $order );
            }
        }

        if ( $limit )
            $qb->setMaxResults( $limit );

        if ( $offset )
            $qb->setFirstResult( $offset );

        return $qb->getQuery()
            ->getResult();
    }    
    
    public function findByNot( array $criteria, array $orderBy = null, $limit = null, $offset = null )
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $qb->select( 'entity' )
            ->from( $this->getEntityName(), 'entity' );

        foreach ( $criteria as $field => $value ) {
	  if($value != null) {
            $qb->andWhere( $expr->neq( 'entity.' . $field, $value ) );
          } else {
	    $qb->andWhere( $expr->isNotNull( 'entity.' . $field ) );
          }
        }

        if ( $orderBy ) {

            foreach ( $orderBy as $field => $order ) {

                $qb->addOrderBy( 'entity.' . $field, $order );
            }
        }

        if ( $limit )
            $qb->setMaxResults( $limit );

        if ( $offset )
            $qb->setFirstResult( $offset );

        return $qb->getQuery()
            ->getResult();
    }

} 
