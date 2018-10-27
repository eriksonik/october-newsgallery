<?php namespace Eriks\NewsGallery\Components;

use Cms\Classes\Page;
use Raviraj\Rjgallery\Components\GalleriesList;
use Raviraj\Rjgallery\Models\Gallery as galleryList;

class NewsGalleriesList extends GalleriesList
{

	private $field;
	private $order;

    public function componentDetails()
    {
        return [
            'name'        => 'NewsGalleriesList',
            'description' => 'Надстройка списка фотогалерей RJ Gallery.'
        ];
    }

    public function defineProperties()
    {
	    return array_merge(parent::defineProperties(), [
		    'sortGallery' => [
			    'title' => 'Sorting',
			    'description' => 'Выбор метода сортировки.',
			    'default' => 'baseFileName',
			    'type' => 'dropdown',
			    'required' => true,
			    'options' => [
				    'name' => 'name',
				    'name_r' => 'name r',
				    'date' => 'date',
				    'date_r' => 'date r',
			    ],
		    ],
	    ]);
    }


	protected function listGalleries()
	{

		/**
		 * Fetch all published galleries
		 */
		$galleries = new galleryList();

//		dd($this->property('sortGallery'));

		switch ($this->property('sortGallery')) {
			case 'name':
				$this->field = 'name';
				$this->order = 'asc';
				break;
			case 'name_r':
				$this->field = 'name';
				$this->order = 'desc';
				break;
			case 'date':
				$this->field = 'created_at';
				$this->order = 'asc';
				break;
			case 'date_r':
			default:
				$this->field = 'created_at';
				$this->order = 'desc';
				break;
		}

		$galleries = $galleries->orderBy($this->field, $this->order)->isPublished()->get();

		/**
		 * Set url's for each gallery
		 */
		$galleries->each(function($gallery){
		    dd($gallery);
			$gallery->setUrl($this->galleryPage,$this->controller);

			$gallery->categories->each(function($category){
				$category->setUrl($this->categoryPage,$this->controller);
			});
		});

		return $galleries;
	}

}