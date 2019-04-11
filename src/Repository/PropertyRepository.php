<?php
	
	namespace App\Repository;
	
	use App\Entity\Property;
	use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
	use Doctrine\ORM\Query;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Bridge\Doctrine\RegistryInterface;
	
	/**
	 * @method Property|null find( $id, $lockMode = null, $lockVersion = null )
	 * @method Property|null findOneBy( array $criteria, array $orderBy = null )
	 * @method Property[]    findAll()
	 * @method Property[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
	 */
	class PropertyRepository extends ServiceEntityRepository
	{
		/**
		 * PropertyRepository constructor.
		 * @param RegistryInterface $registry
		 */
		public function __construct( RegistryInterface $registry )
		{
			parent::__construct($registry, Property::class);
		}
		
		/**
		 * @return Query
		 */
		public function findAllVisibleQuery():query
		{
			return $this->findVisibleQuery()
				->getQuery();
		}
		
		/**
		 * @return Property []
		 */
		public function findLatest():array
		{
			return $this->findVisibleQuery()
				->setMaxResults(4)
				->getQuery()
				->getResult();
		}
		
		private function findVisibleQuery():QueryBuilder
		{
			return $this->createQueryBuilder('p')
				->where('p.sold = false');
		}
		
	}
