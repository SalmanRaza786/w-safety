<?php

namespace App\Providers;

use App\Events\SendEmailEvent;
use App\Listeners\SendEmailListener;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\appointment\AppointmentRepositry;
use App\Repositries\appSettings\AppSettingsInterface;
use App\Repositries\appSettings\AppSettingsRepositry;
use App\Repositries\carriers\CarriersInterface;
use App\Repositries\carriers\CarriersRepositry;
use App\Repositries\category\CategoryInterface;
use App\Repositries\category\CategoryRepositry;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\checkIn\CheckInRepositry;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\companies\CompaniesRepositry;
use App\Repositries\customer\CustomerInterface;
use App\Repositries\customer\CustomerRepositry;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\customField\CustomFieldRepositry;
use App\Repositries\dock\DockInterface;
use App\Repositries\dock\DockRepositry;
use App\Repositries\inventory\InventoryInterface;
use App\Repositries\inventory\InventoryRepositry;
use App\Repositries\loadType\loadTypeInterface;
use App\Repositries\loadType\loadTypeRepositry;

use App\Repositries\media\MediaInterface;
use App\Repositries\media\MediaRepositry;
use App\Repositries\missing\MissingInterface;
use App\Repositries\missing\MissingRepositry;
use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\offLoading\OffLoadingRepositry;


use App\Repositries\notification\NotificationInterface;
use App\Repositries\notification\NotificationRepositry;


use App\Repositries\order\OrderInterface;
use App\Repositries\order\OrderRepositry;
use App\Repositries\orderContact\OrderContactInterface;
use App\Repositries\orderContact\OrderContactRepositry;

use App\Repositries\orderStatus\OrderStatusInterface;
use App\Repositries\orderStatus\OrderStatusRepositry;
use App\Repositries\packagingList\PackagingListInterface;
use App\Repositries\packagingList\PackagingListRepositry;
use App\Repositries\permissions\PermissionInterface;
use App\Repositries\permissions\PermissionRepositry;
use App\Repositries\picking\PickingInterface;
use App\Repositries\picking\PickingRepositry;
use App\Repositries\product\ProductInterface;
use App\Repositries\product\ProductRepositry;
use App\Repositries\putaway\PutAwayInterface;
use App\Repositries\putaway\PutawayRepositry;
use App\Repositries\qc\QcInterface;
use App\Repositries\qc\QcRepositry;
use App\Repositries\roles\RoleInterface;
use App\Repositries\roles\RoleRepositry;
use App\Repositries\user\UserInterface;
use App\Repositries\user\UserRepositry;
use App\Repositries\wh\WhInterface;
use App\Repositries\wh\WhRepositry;
use App\Repositries\workOrder\WorkOrderInterface;
use App\Repositries\workOrder\WorkOrderRepositry;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(AppSettingsInterface::class,AppSettingsRepositry::class);
        $this->app->bind(PermissionInterface::class,PermissionRepositry::class);
        $this->app->bind(RoleInterface::class,RoleRepositry::class);
        $this->app->bind(UserInterface::class,UserRepositry::class);
        $this->app->bind(CategoryInterface::class,CategoryRepositry::class);
        $this->app->bind(ProductInterface::class,ProductRepositry::class);
        $this->app->bind(CustomerInterface::class,CustomerRepositry::class);
        $this->app->bind(OrderInterface::class,OrderRepositry::class);

    }
}
