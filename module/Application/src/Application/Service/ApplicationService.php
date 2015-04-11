<?php

namespace Application\Service;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;

use Service\Entity;

class ApplicationService extends Entity
{
    public $reader;
    public $annotationService;
    public $entity;
    
    public function init()
    {
      $this->reader = new AnnotationReader();
      $this->annotationService = $this->sm->get('Annotations\Service');
    }

   
    public function getImagen($id)
    {
	
      return $this->em->getRepository('Entities\Imagen')->findOneById($id);
    }
	
    public function procImg($id)
    {
	$img = $this->em->getRepository('Entities\Imagen')->findOneById($id);
	$img->set('is_procesed',true);
	$this->em->persist($img);
	$this->em->flush();	

    }
    public function getImagenes($amount, $proc = false)
    {
		//Retrieve the EntityManager first
		$em = $this->em;

		//Get the number of rows from your table
		if($proc){
			$rows = $em->createQuery('SELECT COUNT(u.id) FROM Entities\Imagen u WHERE u.is_procesed = 0')->getSingleScalarResult();
		} else {
			$rows = $em->createQuery('SELECT COUNT(u.id) FROM Entities\Imagen u')->getSingleScalarResult();
		}
		srand((double) microtime() * 1000000); 
		$offset = max(0, rand(0, $rows - $amount - 1));
		
		if($proc) {
			//Get the first $amount users starting from a random point
			$query = $em->createQuery('
						SELECT DISTINCT u
						FROM Entities\Imagen u
						WHERE u.is_procesed = 0')
			->setMaxResults($amount)
			->setFirstResult($offset);
		} else {
			//Get the first $amount users starting from a random point
			$query = $em->createQuery('
						SELECT DISTINCT u
						FROM Entities\Imagen u')
			->setMaxResults($amount)
			->setFirstResult($offset);

		}
		$result = $query->getResult();  	
      return $result;
    }
	
	public function addPropuesta($data)
	{
		$prop = new \Entities\Propuesta();
		
		$img = $this->getImagen($data['id']);
		
		$prop->set('imagen',$img);
		$prop->set('is_procesed', false);
		
		$prop->set('series', $data['serie']);
		$prop->set('personajes', $data['personaje']);
		$prop->set('parejas', $data['pareja']);
		
		$desc = "Es yaoi: " . $data['yaoi_sino'] . "- Conoce: " . $data['conoce_sino'] . "- Hard o Soft: " . $data['hard_soft'] . "-" . $data['descripcion'];
		$prop->set('descripcion', $desc);
		
		$this->em->persist($prop);
		$this->em->flush();
		
	}

} 

 
