<?php declare(strict_types=1);

namespace App\Domain\User;

enum RolesEnum: string {
    case Student = 'ROLE_STUDENT';
    case Coach = 'ROLE_COACH';
}
