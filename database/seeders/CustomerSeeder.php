<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'Maria Oliveira',
            'email' => 'maria@gmail.com',
            'phone' => '31999990001',
        ]);

        Customer::create([
            'name' => 'João Silva',
            'email' => 'joao@gmail.com',
            'phone' => '31999990002',
        ]);

        Customer::create([
            'name' => 'Genésio',
            'email' => 'genesio@gmail.com',
            'phone' => '31999990003',
        ]);

        Customer::create([
            'name' => 'Luis Henrique',
            'email' => 'luishenrique@gmail.com',
            'phone' => '31999990004',
        ]);

        Customer::create([
            'name' => 'Clésio',
            'email' => 'clesio@gmail.com',
            'phone' => '31999990005',
        ]);

        Customer::create([
            'name' => 'Bruno',
            'email' => 'bruno@gmail.com',
            'phone' => '31999990006',
        ]);

        Customer::create([
            'name' => 'Henrique',
            'email' => 'henrique@gmail.com',
            'phone' => '31999990007',
        ]);

        Customer::create([
            'name' => 'Gabriel',
            'email' => 'gabriel@gmail.com',
            'phone' => '31999990008',
        ]);
    }
}
