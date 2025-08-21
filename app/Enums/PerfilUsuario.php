<?php

namespace App\Enums;

use Ramsey\Uuid\Type\Integer;

enum PerfilUsuario: INT
{
    case ADMIN = 1;
    case USUARIO_PADRAO = 2;
}
