<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Services\Company\CompanyServiceInterface;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyServiceInterface $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $companies = $user->companies;
        return response()->json($companies);
    }

    public function store(CompanyRequest $request)
    {
        try {
            $result = $this->companyService->createCompany($request->only(['title', 'phone', 'description']), auth()->id());
        } catch (ValidationException $e) {
            return ['error' => 'Company not created!', 'exception' => $e->getMessage()];
        }
        return $result;
    }
}
