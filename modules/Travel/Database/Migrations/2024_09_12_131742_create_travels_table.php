<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Travel\Enums\V1\TravelStatus\TravelStatus;
use Modules\User\Enums\V1\AccountStatus\AccountStatus;
use Modules\User\Enums\V1\AccountType\AccountType;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('passenger_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('users')->cascadeOnDelete();
            $table->string('tracking_code')->unique();
            $table->tinyInteger('status')->default(TravelStatus::Accepted->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
