<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(FractionsTableSeeder::class);
        $this->call(MarksTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(TimezonesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(StationsTableSeeder::class);
        $this->call(PercentsTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(DealsTableSeeder::class);
        $this->call(ClientAnswersTableSeeder::class);
        $this->call(DealFilesTableSeeder::class);
        $this->call(DealHistoriesTableSeeder::class);
        $this->call(DealTemplateFilesTableSeeder::class);
        $this->call(DeliveryCommentsTableSeeder::class);
        $this->call(ShippingCommentsTableSeeder::class);
        $this->call(UserTasksTableSeeder::class);
        $this->call(AutoTasksTableSeeder::class);
    }
}
