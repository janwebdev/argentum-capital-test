<?php

namespace contracts;

interface ResolverInterface
{
    public function resolveAccess(string $username, string $moduleName, string $functionName): bool;
}