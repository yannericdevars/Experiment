<?php

namespace DW\EntityManagerBundle\Service;

/**
 * Manager des entites
 * 
 * @author Devars Yann-Eric <yann-eric@live.fr>
 */
class ManagerEntitiesService
{

  /**
   * Récupère une entité par son id
   * @param controler $controller Le controleur
   * @param int       $id         L'identifiant
   * @param string    $repository Nom du repository
   * @param Object    $em         Entity manager
   *
   * @return entite
   */
  public static function getEntity($controller, $id, $repository, $em=null)
  {

    if ($em == null) {
      $em = $controller->getDoctrine()->getManager();
    }

    $entity = $em->getRepository($repository)->find($id);

    return $entity;
  }

  /**
   * Recupere des entites selon des criteres
   * @param controler $controller Le controler
   * @param array     $criteria   Les criteres
   * @param string    $repository Nom du repository
   * @param string    $order      Ordre du tri
   *
   * @return array Tableau d'entites
   */
  public static function getEntitiesByCriterias($controller, $criteria, $repository, $order = null)
  {
    $em = $controller->getDoctrine()->getManager();

    return $em->getRepository($repository)->findBy($criteria, $order);
  }

  /**
   * Recupere une entite selon un critere
   * @param controler $controller Le controler
   * @param array     $criteria   Les criteres
   * @param string    $repository Nom du repository
   * @param Object    $em         Entity manager
   *
   * @return Entity L'entite
   */
  public static function getEntityByCriterias($controller, $criteria, $repository, $em=null)
  {
    if ($em == null) {
      $em = $controller->getDoctrine()->getManager();
    }

    return $em->getRepository($repository)->findOneBy($criteria);
  }

  /**
   * Recupere toues les entites
   * @param controler $controller Le controler
   * @param string    $repository Nom du repository
   *
   * @return Entity L'entite
   */
  public static function getAllEntities($controller, $repository)
  {
    $em = $controller->getDoctrine()->getManager();

    return $em->getRepository($repository)->findAll();
  }

  /**
   * Récupère des entitees stockees dans APC
   * @param Controller $controller Un controleur
   * @param $idAPC     $idAPC      Id dans APC
   * @param int        $timeToLive Le nombre de secondes ou la donnee est stockee
   * @param string     $repository Nom du repository
   *
   * @return array les entites
   */
  public static function getAllEntitiesWithApc($controller, $idAPC, $timeToLive, $repository)
  {

    if (!apc_exists($idAPC)) {
      self::writeToApc($controller, $idAPC, $timeToLive, $repository);
    }

    return self::readFromApc($idAPC);
  }

  /**
   * Ecrit dans le cache apc
   * @param Controller $controller Un controleur
   * @param $idAPC     $idAPC      Id dans APC
   * @param string     $repository Nom du repository
   * @param int        $timeToLive Le nombre de secondes ou la donnee est stockee
   */
  public static function writeToApc($controller, $idAPC, $repository, $timeToLive = 30)
  {
    $em = $controller->getDoctrine()->getManager();
    $entities = $em->getRepository($repository)->findAll();
    $tabToRecord = array();
    foreach ($entities as $value) {
      $tabToRecord[] = $value->objetCustomSerialize();
    }

    apc_add($idAPC, $tabToRecord, $timeToLive);
  }

  /**
   * Recupere un tableau d'entites
   * @param $idAPC $idAPC Id dans APC
   *
   * @return array tableau d'entite
   */
  public static function readFromApc($idAPC)
  {
    return apc_fetch($idAPC);
  }

  /**
   * Sauvegarde une entité
   * @param controler $controller Le controler
   * @param entite    $entity     L'entite
   */
  public static function saveEntity($controller, $entity)
  {
    $em = $controller->getDoctrine()->getEntityManager();
    $em->persist($entity);
    $em->flush();
  }

  /**
   * Supprime une entité
   * @param controler $controller Le controler
   * @param entite    $entity     L'entite
   */
  public static function deleteEntity($controller, $entity)
  {
    $em = $controller->getDoctrine()->getEntityManager();
    $em->remove($entity);
    $em->flush();
  }

  /**
   * Permet de faire une requete DQL
   * @param controler     $controller Le controleur
   * @param string        $strQuery   La chaine de requete
   * @param EntityManager $em         Un entity manager peut être precise
   *
   * @return Tableau d'objets
   */
  public static function selectByDQL($controller, $strQuery, $em = null)
  {
    if ($controller != null) {
      $em = $controller->getDoctrine()->getManager();
    }

    $query = $em->createQuery($strQuery);

//    var_dump($query->getSQL()); die;

    return $query->getResult();
  }

  /**
   * Permet de faire une requete DQL
   * @param controler $controller Le controleur
   * @param string    $strQuery   La chaine de requete
   * @param int       $limit      Limite des reponses
   *
   * @return Tableau d'objets
   */
  public static function selectByDQLWithLimit($controller, $strQuery, $limit=null)
  {
    if ($controller != null) {
      $em = $controller->getDoctrine()->getManager();
    }

    $query = $em->createQuery($strQuery);

    $query->setMaxResults($limit);

    return $query->getResult();
  }

}
