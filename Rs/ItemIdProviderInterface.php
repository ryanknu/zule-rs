<?php

namespace Zule\Rs;

interface ItemIdProviderInterface
{
    // Converts any given input key to a runescape item id.
    // Allows the implementor to maintain their own proprietary
    // database / API formats.
    public function convert($id);
}
