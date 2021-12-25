<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\Task;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

class TaskRequest
{
    #[Assert\NotBlank]
    public string $title;

    #[Pure]
    public static function from(Task $task): TaskRequest
    {
        $request = new TaskRequest();
        $request->title = $task->getTitle();

        return $request;
    }
}
