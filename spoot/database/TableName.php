<?php

namespace Spoot\Database;

use Attribute;

#[Attribute]
class TableName
{
    public function __construct(
        public string $name
    ) {
    }
}
