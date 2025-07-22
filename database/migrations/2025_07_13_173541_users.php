    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('user_id', 22)->unique(); // UUID or random string
                $table->string('mobile', 15)->unique();
                $table->string('name')->nullable();
                $table->string('email')->unique()->nullable();
                $table->enum('gender', ['male', 'female', 'other'])->nullable();
                $table->string('dob')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->string('referral_code', 10)->nullable();
                $table->string('referred_by', 10)->nullable();
                $table->timestamps();
            });
        }

        public function down(): void {
            Schema::dropIfExists('users');
        }
    };
