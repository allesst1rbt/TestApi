<?php


namespace App\Repositories;


class HomeRepository implements HomeRepositoryInterface
{

    public function welcomeMessage() : string{
        return "PHP Challenge 20201117";
    }
}
