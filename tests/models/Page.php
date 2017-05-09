<?php

namespace Soda\ClosureTable\Tests\Models;

use Soda\ClosureTable\Models\Entity;

class Page extends Entity
{
    protected $table = 'entities';
    protected $fillable = ['id', 'title', 'excerpt', 'body', 'position', 'real_depth'];
}
