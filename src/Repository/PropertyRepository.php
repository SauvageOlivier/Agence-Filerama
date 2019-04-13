<?php
	
	namespace App\Repository;
	
	use App\Entity\Property;
	use App\Entity\PropertySearch;
	use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
	use Doctrine\ORM\Query;
	use Doctrine\ORM\QueryBuilder;
	use Symfony\Bridge\Doctrine\RegistryInterface;
	
	
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
		 * @param PropertySearch $search
		 * @return Query
		 */
		public function findAllVisibleQuery( PropertySearch $search ):query
		{
			$query = $this->findVisibleQuery();
			
			if ($search->getMaxPrice()) {
				$query = $query
					->andWhere('p.price <= :maxprice')
					->setParameter('maxprice', $search->getMaxPrice());
			}
			
			if ($search->getMinSurface()) {
				$query = $query
					->andwhere('p.surface >= :minsurface')
					->setParameter('minsurface', $search->getMinSurface());
			}
			
			return $query->getQuery();
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
		
		/**
		 * @return QueryBuilder
		 */
		private function findVisibleQuery():QueryBuilder
		{
			return $this->createQueryBuilder('p')
				->where('p.sold = false');
		}
		
	}
