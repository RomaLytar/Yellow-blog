<?php
namespace App\Services\Company;

interface CompanyServiceInterface
{
    public function createCompany(array $data, int $userId);
}
