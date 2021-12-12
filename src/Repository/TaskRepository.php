<?php

namespace App\Repository;

use App\Entity\Task;
use App\Exception\ORM\NotFoundException;
use App\Exception\ORM\ORMRemoveException;
use App\Exception\ORM\ORMStoreException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

/**
 * Class TaskRepository
 * @package App\Repository
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function list(): array
    {
        return $this->findAll();
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Task
    {
        $task = $this->find($id);

        if ($task === null) {
            throw new NotFoundException('Task not found.');
        }

        return $task;
    }

    /**
     * @throws ORMStoreException
     */
    public function store(Task $task): Task
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($task);
            $em->flush();
        } catch (Throwable $t) {
            throw new ORMStoreException($t->getMessage());
        }

        return $task;
    }

    /**
     * @throws ORMRemoveException
     */
    public function remove(Task $task): void
    {
        $em = $this->getEntityManager();

        try {
            $em->remove($task);
            $em->flush();
        } catch (Throwable $t) {
            throw new ORMRemoveException($t->getMessage());
        }
    }
}
