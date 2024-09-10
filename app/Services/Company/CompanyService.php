<?php
namespace App\Services\Company;

use App\Repositories\Company\CompanyRepositoryInterface;

class CompanyService implements CompanyServiceInterface
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function createCompany(array $data, int $userId)
    {
        $data['user_id'] = $userId;
        $company = $this->companyRepository->create($data);
        return response()->json([
            'id' => $company->id,
            'title' => $company->title,
            'phone' => $company->description,
            'created_at' => $company->created_at,
            'updated_at' => $company->updated_at,
        ], 201);
    }
}
