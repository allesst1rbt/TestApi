<?php

namespace App\Http\Controllers;


use App\Repositories\HomeRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $homeRepositoryInterface;
    public function __construct(HomeRepositoryInterface $homeRepositoryInterface)
    {
        $this->homeRepositoryInterface = $homeRepositoryInterface;
    }
    public function index() : \Illuminate\Http\JsonResponse{
        return response()->json(['message'=>$this->homeRepositoryInterface->welcomeMessage()]);
    }
}
