<?php

namespace Api\Domain\User;

interface UserRepo
{
    public function create(User $user): bool;
    public function read(int $id): mixed;
    public function update(int $id, User $user): bool;
    public function delete(int $id): bool;
}
