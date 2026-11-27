<?php

namespace App;

enum UserRole: string
{
    case Administrator = 'admin';
    case Student = 'student';
}
