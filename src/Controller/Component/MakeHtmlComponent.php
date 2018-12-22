<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class MakeHtmlComponent extends Component
{
	public function makeHtmlForPictures($picture)
	{
		return h('<img class="mx-auto d-block" style="max-width:100%" src="/zenmonk/img/pictures/' . $picture->title . '.' . $picture->extension . '">');
	}

	public function makeHtmlForProcessings($processing){
		return h('<script src="/zenmonk/js/processings/' . $processing->title . '.js"></script>'
			.'<div><canvas class="mx-auto d-block" style="max-width:100%" id="processing"></canvas></div>'
		);	
	}

	public function makeHtmlForArticles($article){
		return h('<div style="max-width:100%">' . $article->content . '</div>');	
	}
}
