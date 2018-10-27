<?php

namespace Eriks\NewsGallery;

use System\Classes\PluginBase;
use Indikator\News\Controllers\Posts as PostsController;
use Indikator\News\Models\Posts as PostModel;

class Plugin extends PluginBase {

    public $require = ['Indikator.News', 'Raviraj.Rjgallery'];

    public function pluginDetails() {
        return [
            'name'        => 'eriks.newsgallery::lang.plugin.name',
            'description' => 'eriks.newsgallery::lang.plugin.description',
            'author'      => 'Martin M., Eriks',
            'icon'        => 'icon-image'
        ];
    }


	public function registerComponents()
	{
		return [
			'Eriks\NewsGallery\Components\NewsGalleriesList' => 'newsGalleriesList'
		];
	}


    public function boot(){

        PostModel::extend(function ($model) {
            $model->belongsTo['rjgallery'] = ['Raviraj\Rjgallery\Models\Gallery'];
        });

        PostsController::extendFormFields(function ($form, $model) {
            if (!$model instanceof PostModel) return;
            $form->addSecondaryTabFields([
                'rjgallery' => [
                    'label'       => 'eriks.newsgallery::lang.form.label',
                    'type'        => 'relation',
                    'emptyOption' => 'eriks.newsgallery::lang.form.empty'
                ]
            ]);
        });

    }

}
