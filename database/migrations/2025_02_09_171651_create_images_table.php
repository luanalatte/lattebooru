<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('type')->index();
            $table->foreignId('parent_id')->nullable()->constrained('images')->cascadeOnDelete();
            $table->char('md5', 32)->unique()->index();
            $table->char('ext', 4);
            $table->string('filename')->nullable();
            $table->unsignedInteger('filesize');
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('image_id')->nullable()->after('user_id')->constrained('images');
        });

        DB::table('images')->insertUsing([
            'type',
            'md5',
            'ext',
            'filename',
            'filesize',
            'width',
            'height',
            'created_at',
            'deleted_at',
        ], DB::table('posts')->select([
            DB::raw(1),
            'md5',
            'ext',
            'filename',
            'filesize',
            'width',
            'height',
            'created_at',
            'deleted_at'
        ]));

        $query = DB::table('posts')
            ->join('images', 'posts.md5', '=', 'images.md5')
            ->select(['posts.id AS post_id', 'images.id AS image_id'])->orderBy('posts.id');

        foreach ($query->lazy(1000) as $post) {
            DB::table('posts')->where('id', $post->post_id)->update([
                'image_id' => $post->image_id
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('image_id')->nullable(false)->change();
            $table->dropUnique('posts_md5_unique');
        });

        Schema::dropColumns('posts', ['md5', 'ext', 'filename', 'filesize', 'width', 'height']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->char('md5', 32)->nullable()->unique();
            $table->char('ext', 4)->nullable();
            $table->string('filename')->nullable();
            $table->unsignedInteger('filesize')->nullable();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
        });

        $query = DB::table('images')
            ->join('posts', 'posts.image_id', '=', 'images.id')
            ->select([
                'posts.id',
                'images.md5',
                'images.ext',
                'images.filename',
                'images.filesize',
                'images.width',
                'images.height'
            ])->orderBy('images.id');

        foreach ($query->lazy(1000) as $image) {
            DB::table('posts')->where('id', $image->id)->update([
                'md5' => $image->md5,
                'ext' => $image->ext,
                'filename' => $image->filename,
                'filesize' => $image->filesize,
                'width' => $image->width,
                'height' => $image->height
            ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('image_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->char('md5', 32)->nullable(false)->change();
            $table->char('ext', 4)->nullable(false)->change();
            $table->string('filename')->nullable(false)->change();
            $table->unsignedInteger('filesize')->nullable(false)->change();
        });

        Schema::dropIfExists('images');
    }
};
