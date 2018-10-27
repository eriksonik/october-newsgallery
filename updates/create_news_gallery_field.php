<?php

    namespace Eriks\NewsGallery\Updates;

    use Schema;
    use October\Rain\Database\Updates\Migration;

    class CreateNewsGalleryField extends Migration {

        public function up() {
            Schema::table('indikator_news_posts', function ($table) {
                $table->integer('rjgallery_id')->unsigned()->nullable();
                $table->foreign('rjgallery_id')->references('id')->on('raviraj_rjgallery_galleries')->onDelete('set null');
            });
        }

        public function down() {
            if(Schema::hasColumn('indikator_news_posts', 'rjgallery_id')) {
                Schema::table('indikator_news_posts', function ($table) {
                    $table->dropForeign('indikator_news_posts_rjgallery_id_foreign');
                    $table->dropColumn('rjgallery_id');
                });
            }
        }

    }

?>