<?php

namespace Admin\Service;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;

use Service\Entity;

class AdminService extends Entity
{
    public $reader;
    public $annotationService;
    public $entity;
    
    public function init()
    {
      $this->reader = new AnnotationReader();
      $this->annotationService = $this->sm->get('Annotations\Service');
    }

    public function getMenu()
    {
	  $menu = array();
    	  $tables = $this->annotationService->getAllMetadataClass();
	  foreach($tables as $t) {
		  $class = $t->getReflectionClass();
		  $description = $this->reader->getClassAnnotation($class, "Annotations\\Description");
		  if($description != null) {
		    $name = $t->name;
		    $name = str_replace($t->namespace."\\", "", $name);
		    $menu[strtolower($name)] = $description->getValue();
		  }
	  }
	  return $menu;
    }
    
    public function setEntity($table)
    {
      $this->entity = "Entities\\". ucfirst($table);
    }
    
    public function getColumn($property, $relation = null)
    {
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Boolean");
      if($annotation != null) return array("type" => $annotation->getType());

      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Color");
      if($annotation != null) return array("type" => $annotation->getType());
      
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\TextField");
      if($annotation != null) return array("type" => $annotation->getType());
      
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\TextAreaHtml");
      if($annotation != null) return array("type" => $annotation->getType());

      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\TextArea");
      if($annotation != null) return array("type" => $annotation->getType());
      
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Imagen");
      if($annotation != null) return array("type" => $annotation->getType());

      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Date");
      if($annotation != null) return array("type" => $annotation->getType());
      
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\ReadOnly");
      if($annotation != null) return array("type" => $annotation->getType());
      
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Hidden");
      if($annotation != null) return array("type" => $annotation->getType());

      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\MultiSelect");
      if($annotation != null) {
	$entity = $this->entity;
	$this->entity = $relation;
	$datos = $this->getAllList();
	$main = $this->getMainField();
	$this->entity = $entity;
	return array("type" => $annotation->getType(), "list" => $datos, "main" => $main, "limit" => $annotation->getLimit());
      }
	  
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Gallery");
      if($annotation != null) {
	$entity = $this->entity;
	$this->entity = $relation;
	//$datos = $this->getAllList();
	$main = $this->getMainField(); 
	$this->entity = $entity;
	return array("type" => $annotation->getType(), "list" => $datos, "main" => $main, "limit" => $annotation->getLimit());
      }
      
      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\Select");
      if($annotation != null) {
	$filter = $this->reader->getPropertyAnnotation($property, "Annotations\\Filter");
	$entity = $this->entity;
	$this->entity = $relation;
	if($filter == null) {
	  $datos = $this->getAllList();
	} else {
	  $datos = $filter->getResults($this->em->getRepository($this->entity));	
	}
	$main = $this->getMainField();
	$this->entity = $entity;
	return array("type" => $annotation->getType(), "list" => $datos, "main" => $main);
      }

      $annotation = $this->reader->getPropertyAnnotation($property, "Annotations\\SelectTree");
      if($annotation != null) {
	$filter = $this->reader->getPropertyAnnotation($property, "Annotations\\Filter");
	$entity = $this->entity;
	$this->entity = $relation;
	if($filter == null) {
	  $datos = $this->getAllList();
	} else {
	  $datos = $filter->getResults($this->em->getRepository($this->entity));	
	}
	$main = $this->getMainField();
	$this->entity = $entity;
	return array("type" => $annotation->getType(), "list" => $datos, "main" => $main);
      }


      return array("type" => "CustomAnnotation");
    }
    
    public function getMainField()
    { 
      $metadata = $this->annotationService->getClassMetadata($this->entity);
      $class = $metadata->getReflectionClass();
      $columns = $metadata->getColumnNames();  
      foreach( $columns as $column ) {
	$property = $class->getProperty($metadata->getFieldName($column));
	$main = $this->reader->getPropertyAnnotation($property, "Annotations\\MainField");
	if($main !=  null) {
	  return $property->getName();
	}
      }  
      return null;
    }
    
    public function getColumnInfo()
    {

      $cols = array();
      $metadata = $this->annotationService->getClassMetadata($this->entity);
      $class = $metadata->getReflectionClass();
      $columns = $metadata->getColumnNames();  
      foreach( $columns as $column ) {
	$property = $class->getProperty($metadata->getFieldName($column));
	$descripcion = $this->reader->getPropertyAnnotation($property, "Annotations\\Description");
	if($descripcion != null) {
	  $cols[$column]['desc'] = $descripcion->getValue();
	  $cols[$column]['column'] = $this->getColumn($property);
	}
      }
      $assoc = $metadata->getAssociationNames();
      foreach( $assoc as $as) {
	  $data = $metadata->getAssociationMapping($as);
	  $property = $class->getProperty($data['fieldName']);
	  $descripcion = $this->reader->getPropertyAnnotation($property, "Annotations\\Description");
	  if($descripcion != null) {
	    $cols[$data['fieldName']]['desc'] = $descripcion->getValue();
	    $cols[$data['fieldName']]['column'] = $this->getColumn($property, $data['targetEntity']);
	  }
	}
      return $cols;
    }
    
    public function getAllList()
    {
	return $this->em->getRepository($this->entity)->findAll();
    }
    
 public function getListMax()
    {
      $limit = 20;
      $metadata = $this->annotationService->getClassMetadata($this->entity);
      $class = $metadata->getReflectionClass();
      $filter = $this->reader->getClassAnnotation($class, "Annotations\\Filter");
            
      if($filter == null) {
	  $qb = $this->em->createQueryBuilder();
	  $qb->select('count(u.id)');
	  $qb->from($this->entity,'u');

	  $count = $qb->getQuery()->getSingleScalarResult();      
	  return ceil($count/$limit);
      }
      return ceil(count(($filter->getResults($this->em->getRepository($this->entity))))/$limit);

    }
    public function getList($page)
    {
      $limit = 20;
      $permisos = array();
      $metadata = $this->annotationService->getClassMetadata($this->entity);
      $class = $metadata->getReflectionClass();
      $abml = $this->reader->getClassAnnotation($class, "Annotations\\ABML");
      if($abml != null) {
	$alta = $abml->getAlta();
	$baja = $abml->getBaja();
	$lista = $abml->getLista();
	$modificacion = $abml->getModificacion();
	$permisos = array("alta" => $alta,"baja" => $baja,"modificacion" => $modificacion, "lista" => $lista);
      }
      $offset = $limit * $page;
      $filter = $this->reader->getClassAnnotation($class, "Annotations\\Filter");
      if($filter == null) {
	
	$result = $this->em->getRepository($this->entity)->findBy(array(), null, $limit, $offset);
      } else {
	$result = $filter->getResults($this->em->getRepository($this->entity));
      }

      return array($result,$permisos);
    }
    
    
    public function getItem($id)
    {
      return $this->em->getRepository($this->entity)->findOneById($id);
    }
    public function deleteItem($id)
    {
      $item = $this->getItem($id);
  
      $this->em->remove($item);
      $this->em->flush();
    }     
    
    public function newItem($data, $file) 
    {
      $item = new $this->entity();
      $data = $data->toArray();
      $file = $file->toArray();
           
      $item = $this->procData($item, $data, $file);

      $this->em->persist($item);
      $this->em->flush();
    }
    
    public function updateItem($data, $file) 
    {
      $item = $this->getItem($data['itemid']);
      
      $data = $data->toArray();
      $file = $file->toArray();

      $item = $this->procData($item, $data, $file);

      $this->em->persist($item);
      $this->em->flush();
    }    
    
    public function procData($item, $data, $file) 
    {
      $uri = array();
      if(count($file) > 0) {
	$files = $this->procFile($file);
	foreach($files as $key => $file) {
	    if($file['error'] == 0) {
	      $uri[$key] = $file['dest'];
	    } else if($file['error'] == 4){
	      $uri[$key] = "nochanges";
	    }
	}
      }
      
      $metadata = $this->annotationService->getClassMetadata($this->entity);
      $class = $metadata->getReflectionClass();
      $columns = $metadata->getColumnNames();  
      $assoc = $metadata->getAssociationNames();
      $columns = array_merge($columns,$assoc);

      foreach($columns as $column) {
	$property = $class->getProperty($metadata->getFieldName($column));
	$prop[$property->getName()] = $this->reader->getPropertyAnnotations($property);
      }
      foreach($prop as $p => $v) {
	if($p != "id") {
	  foreach($v as $obj) {
		$value = null;
	    if($obj instanceof \Doctrine\ORM\Mapping\Column) {
	      if(in_array($p,array("start_date","end_date","date"))) {
		$data[$p] = \DateTime::createFromFormat("d/m/Y",$data[$p]);
		if(!$data[$p]) { $data[$p] = new \DateTime(); $data[$p]->setTimestamp(0); }
	      }
	      if($p == "filename") {
		if($uri[$p] != "nochanges") {
		  $data[$p] = $uri[$p];
		} else {
		  $data[$p] = $item->get('filename');
		}
	      }
	      $item->set($p,$data[$p]);
	    }
	    if($obj instanceof \Doctrine\ORM\Mapping\ManyToOne) {
	      $assocData = $metadata->getAssociationMapping($p);
	      $value = $this->em->getRepository($assocData['targetEntity'])->findOneById($data[$p]);
	      $item->set($p,$value);
	    }
	    if($obj instanceof \Doctrine\ORM\Mapping\ManyToMany) {
	      $assocData = $metadata->getAssociationMapping($p);
	      if(isset($data[$p])) {
		  $values = array();
		foreach($data[$p] as $val) {
		  $values[] = $this->em->getRepository($assocData['targetEntity'])->findOneById($val);
		}	
		$value = new ArrayCollection($values);
	      } else {
		$value = new ArrayCollection();
	      } 
	      $item->set($p,$value);
	    }
	  }
	}
      }
       
      return $item;
    }
    
    public function procFile($files)
    {
      $dir =  "D:\Inetpub\parquecanuelas\upload\\";
      foreach($files as $key => $file) {
	$filename = $dir . uniqid() . $file['name'];
	move_uploaded_file($file['tmp_name'], $filename);
	$filename = str_replace($dir , "upload/", $filename);
	$files[$key]['dest'] = $filename;
      }
      return $files;
    }
} 
