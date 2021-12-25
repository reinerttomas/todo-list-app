<?php
declare(strict_types=1);

namespace App\Dto;

use App\Entity\TaskStatus;
use Symfony\Component\Validator\Constraints as Assert;

class TaskStatusChangeRequest
{
    #[Assert\NotBlank]
    public TaskStatus $status;
}
