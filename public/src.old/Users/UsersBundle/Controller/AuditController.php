<?php

namespace Users\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;
use DataDog\PagerBundle\Pagination;
use DataDog\AuditBundle\Entity\AuditLog;

class AuditController extends Controller {

    use DoctrineControllerTrait;

    public function filters(QueryBuilder $qb, $key, $val) {
        switch ($key) {
            case 'history':
                if ($val) {
                    $orx = $qb->expr()->orX();
                    $orx->add('s.fk = :fk');
                    $orx->add('t.fk = :fk');

                    $qb->andWhere($orx);
                    $qb->setParameter('fk', intval($val));
                }
                break;
            case 'class':
                $orx = $qb->expr()->orX();
                $orx->add('s.class = :class');
                $orx->add('t.class = :class');

                $qb->andWhere($orx);
                $qb->setParameter('class', $val);
                break;
            case 'blamed':
                if ($val === 'null') {
                    $qb->andWhere($qb->expr()->isNull('a.blame'));
                } else {
                    // this allows us to safely ignore empty values
                    // otherwise if $qb is not changed, it would add where the string is empty statement.
                    $qb->andWhere($qb->expr()->eq('b.fk', ':blame'));
                    $qb->setParameter('blame', $val);
                }
                break;
            default:
                // if user attemps to filter by other fields, we restrict it
                throw new \Exception("filter not allowed");
        }
    }

    public function indexAction(Request $request) {
        //$this->someActions();
        Pagination::$defaults = array_merge(Pagination::$defaults, ['limit' => 100]);

        $qb = $this->repo("DataDogAuditBundle:AuditLog")
                ->createQueryBuilder('a')
                ->addSelect('s', 't', 'b')
                ->innerJoin('a.source', 's')
                ->leftJoin('a.target', 't')
                ->leftJoin('a.blame', 'b');



        $options = [
            'sorters' => ['a.loggedAt' => 'DESC'],
            'applyFilter' => [$this, 'filters'],
        ];

        $sourceClasses = [
            Pagination::$filterAny => 'Toutes les classes',
        ];

        foreach ($this->getDoctrine()->getManager()->getMetadataFactory()->getAllMetadata() as $meta) {
            if ($meta->isMappedSuperclass || strpos($meta->name, 'DataDog\AuditBundle') === 0) {
                continue;
            }
            $parts = explode('\\', $meta->name);
            $sourceClasses[$meta->name] = end($parts);
        }

        $users = [
            Pagination::$filterAny => 'Tous les utilisateurs',
            'null' => 'Unknown',
        ];
        foreach ($this->repo('UsersBundle:Users')->findAll() as $user) {
            if ($user->getAgent()) {
                $users[$user->getId()] = (string) $user;
            }
        }

        $logs = new Pagination($qb, $request, $options);


        return $this->render('UsersBundle:Audit:index.html.twig', compact('logs', 'sourceClasses', 'users'));

        // return ;
    }

    public function diffAction(AuditLog $log) {


        $fields = json_decode(($log->getDiff()), true);

        return $this->render('UsersBundle:Audit:diff.html.twig', compact('log', 'fields'));
        //return compact('log');
    }

}
